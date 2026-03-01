<?php

namespace App\Support;

class Currency
{
    public static function yen($value): string
    {
        $value = (string) $value;
        if (preg_match_all('/\d+/', $value, $matches) && count($matches[0]) > 1) {
            $parts = array_map(function ($n) {
                return '¥' . number_format((int) $n);
            }, $matches[0]);
            return implode('–', $parts);
        }
        $num = preg_replace('/\D+/', '', $value);
        return $num !== '' ? '¥' . number_format((int) $num) : $value;
    }
}
