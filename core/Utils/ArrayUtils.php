<?php

namespace Core\Utils;

class ArrayUtils
{
    public static function find(array $arr, $str)
    {
        foreach ($arr as $item) {
            if(self::isMatchedString($item, $str)) {
                return $item;
            }
        }

        return false;
    }

    private static function isMatchedString($str1, $str2) {
        return preg_match(sprintf('/^%s$/', str_replace('*', '.*', str_replace('.', '\.', $str1))), $str2)
            || preg_match(sprintf('/^%s$/', str_replace('*', '.*', str_replace('.', '\.', $str2))), $str1);
    }
}