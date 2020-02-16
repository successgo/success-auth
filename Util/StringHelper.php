<?php


namespace SuccessGo\SuccessAuth\Util;


class StringHelper
{
    public static function appendIfNotContain(string $s, string $appendStr, string $otherwise): string
    {
        if (empty($s) || empty($appendStr)) {
            return $s;
        }
        if (self::contains($s, $appendStr)) {
            return $s . $otherwise;
        }
        return $s . $appendStr;
    }

    public static function contains(string $haystack, string $needle)
    {
        return strpos($haystack, $needle) !== false;
    }
}
