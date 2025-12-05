<?php
/**
 * system/Core/Di.php
 *
 * Реализация DI-контейнера в стиле Phalcon\Di на чистом PHP.
 * - Поддержка shared (singleton) и factory (каждый раз новый объект).
 * - Магический доступ к сервисам ($di->db).
 * - Алиасы для сервисов.
 * - "Дефолтный" контейнер (singleton).
 */

namespace System\Core;

class Di
{
    /** @var Di|null Статическая ссылка на "дефолтный" контейнер */
    protected static ?Di $default = null;

    /** @var array<string, callable|mixed> Хранилище определений сервисов */
    protected array $services = [];

    /** @var array<string, mixed> Кэш для shared-сервисов */
    protected array $sharedInstances = [];

    /** @var array<string, string> Алиасы: имя → реальное имя сервиса */
    protected array $aliases = [];

    /**
     * Конструктор.
     * Если ещё не установлен "дефолтный" контейнер — делаем текущий таковым.
     */
    public function __construct()
    {
        if (self::$default === null) {
            self::$default = $this;
        }
    }

    /**
     * Получить "дефолтный" контейнер.
     */
    public static function getDefault(): ?Di
    {
        return self::$default;
    }

    /**
     * Зарегистрировать сервис как factory.
     * Каждый вызов get() будет создавать новый объект.
     *
     * @param string $name Имя сервиса
     * @param callable|mixed $definition Фабрика или готовый объект
     */
    public function set(string $name, $definition): void
    {
        $this->services[$name] = $definition;
    }

    /**
     * Зарегистрировать сервис как shared.
     * Первый вызов создаёт объект, далее возвращается кэш.
     *
     * @param string $name Имя сервиса
     * @param callable|mixed $definition Фабрика или готовый объект
     */
    public function setShared(string $name, $definition): void
    {
        $this->services[$name] = $definition;
        $this->sharedInstances[$name] = null; // резервируем место в кэше
    }

    /**
     * Создать алиас для сервиса.
     * Позволяет обращаться к одному сервису под разными именами.
     *
     * @param string $alias Алиас
     * @param string $serviceName Реальное имя сервиса
     */
    public function setAlias(string $alias, string $serviceName): void
    {
        $this->aliases[$alias] = $serviceName;
    }

    /**
     * Получить реальное имя сервиса по алиасу.
     */
    protected function resolveAlias(string $name): string
    {
        return $this->aliases[$name] ?? $name;
    }

    /**
     * Получить сервис (factory или shared).
     * Если сервис зарегистрирован через setShared() - возвращает singleton.
     * Если через set() - создаёт новый объект каждый раз.
     *
     * @param string $name Имя сервиса или алиас
     * @param array $parameters Доп. параметры для фабрики
     * @return mixed
     */
    public function get(string $name, array $parameters = [])
    {
        $name = $this->resolveAlias($name);

        if (!isset($this->services[$name])) {
            throw new \RuntimeException("Service '{$name}' not found in DI");
        }

        // Если сервис зарегистрирован как shared - используем getShared()
        if (array_key_exists($name, $this->sharedInstances)) {
            return $this->getShared($name, $parameters);
        }

        $definition = $this->services[$name];

        // Если это фабрика — вызываем её
        if (is_callable($definition)) {
            return $definition($this, $parameters);
        }

        // Если это готовый объект/значение — возвращаем напрямую
        return $definition;
    }

    /**
     * Получить shared-сервис.
     * Создаётся один раз, потом возвращается из кэша.
     *
     * @param string $name Имя сервиса или алиас
     * @param array $parameters Доп. параметры для фабрики
     * @return mixed
     */
    public function getShared(string $name, array $parameters = [])
    {
        $name = $this->resolveAlias($name);

        if (!isset($this->services[$name])) {
            throw new \RuntimeException("Service '{$name}' not found in DI");
        }

        // Если в кэше ещё нет — создаём
        if ($this->sharedInstances[$name] === null) {
            $definition = $this->services[$name];
            $this->sharedInstances[$name] = is_callable($definition)
                ? $definition($this, $parameters)
                : $definition;
        }

        return $this->sharedInstances[$name];
    }

    /**
     * Проверка наличия сервиса.
     */
    public function has(string $name): bool
    {
        $name = $this->resolveAlias($name);
        return isset($this->services[$name]);
    }

    /**
     * Удалить сервис.
     */
    public function remove(string $name): void
    {
        $name = $this->resolveAlias($name);
        unset($this->services[$name], $this->sharedInstances[$name]);
    }

    /**
     * Магический доступ к сервисам.
     * Позволяет писать $di->db вместо $di->getShared('db').
     */
    public function __get(string $name)
    {
        return $this->getShared($name);
    }
}