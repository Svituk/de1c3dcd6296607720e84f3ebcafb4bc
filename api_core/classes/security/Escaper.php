<?php

namespace System\Core\Security;

class Escaper
{
    public function escapeHtml(string $str): string
    {
        return htmlspecialchars($str, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    public function escapeJs(string $str): string
    {
        // Экранируем спецсимволы для безопасной вставки в JS-строки
        return str_replace(
            ["\\", "'", "\"", "\n", "\r", "</"],
            ["\\\\", "\\'", "\\\"", "\\n", "\\r", "<\/"],
            $str
        );
    }

    public function escapeUrl(string $str): string
    {
        return rawurlencode($str);
    }

    public function escapeCss(string $str): string
    {
        // Экранируем кавычки, обратные слэши, переводы строк и управляющие символы
        $escaped = addcslashes($str, "\"'\\\n\r\f\t\v");
        // Дополнительно экранируем не‑ASCII символы в формате \HHHH
        $out = '';
        $len = mb_strlen($escaped, 'UTF-8');
        for ($i = 0; $i < $len; $i++) {
            $ch = mb_substr($escaped, $i, 1, 'UTF-8');
            $converted = mb_convert_encoding($ch, 'UCS-4BE', 'UTF-8');
            $unpacked = unpack('N', $converted);
            if ($unpacked !== false && isset($unpacked[1])) {
                $code = $unpacked[1];
                if ($code < 32 || $code > 126) {
                    $out .= sprintf("\\%04X", $code);
                } else {
                    $out .= $ch;
                }
            } else {
                // Если не удалось конвертировать - оставляем символ как есть
                $out .= $ch;
            }
        }
        return $out;
    }
}