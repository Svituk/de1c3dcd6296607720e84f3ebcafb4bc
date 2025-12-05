<?php
namespace System\Core\Security;

class Filter
{
    /**
     * Очистить значение по одному или нескольким фильтрам.
     *
     * @param mixed $value   Значение
     * @param string|array $filters Один фильтр или массив фильтров
     * @return mixed
     */
    public function sanitize(mixed $value, string|array $filters): mixed
    {
        foreach ((array)$filters as $filter) {
            $value = $this->apply($value, $filter);
        }
        return $value;
    }

    /**
     * Очистить массив данных по карте.
     *
     * @param array $data Входные данные
     * @param array $map  Карта фильтров: ['field' => 'filter' или ['filter1','filter2']]
     * @return array
     */
    public function sanitizeArray(array $data, array $map): array
    {
        $result = [];
        foreach ($map as $field => $filters) {
            $result[$field] = $this->sanitize($data[$field] ?? null, $filters);
        }
        return $result;
    }

    /**
     * Применить конкретный фильтр.
     */
    private function apply(mixed $value, string $filter): mixed
    {
        return match ($filter) {
            'string'      => is_string($value) ? trim(strip_tags($value)) : (string)$value,
            'int'         => (int)$value,
            'float'       => (float)$value,
            'bool'        => (bool)$value,
            'trim'        => is_string($value) ? trim($value) : $value,
            'lower'       => is_string($value) ? mb_strtolower($value) : $value,
            'upper'       => is_string($value) ? mb_strtoupper($value) : $value,
            'stripTags'   => is_string($value) ? strip_tags($value) : $value,
            'alnum'       => is_string($value) ? preg_replace('/[^a-zA-Z0-9]/u', '', $value) : $value,
            'digits'      => is_string($value) ? preg_replace('/\D/u', '', $value) : $value,
            'email'       => filter_var($value, FILTER_SANITIZE_EMAIL),
            'url'         => filter_var($value, FILTER_SANITIZE_URL),
            // ВНИМАНИЕ: 'specialchars' удален - используйте display_html() при выводе!
            // Filter предназначен ТОЛЬКО для очистки входных данных, НЕ для экранирования вывода
            default       => $value,
        };
    }
}
