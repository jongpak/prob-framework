<?php

namespace Core\Utils;

use InvalidArgumentException;

class ArrayUtils
{
    /**
     * @param array $arr
     * @param $str
     * @return string|false return matching pattern
     */
    public static function find(array $arr, $str)
    {
        foreach ($arr as $key => $value) {
            $item = is_int($key) ? $value : $key;

            if(is_string($item) === false) {
                throw new InvalidArgumentException('Given array contain not string key');
            }

            if(self::isMatchedString($item, $str)) {
                return $item;
            }
        }

        return false;
    }

    private static function isMatchedString($str1, $str2) {
        $quotedStr1 = preg_quote($str1);
        $quotedStr2 = preg_quote($str2);

        $inspectStr1 = str_replace('\\*', '.*', $quotedStr1);
        $inspectStr2 = str_replace('\\*', '.*', $quotedStr2);

        return preg_match(sprintf('/^%s$/', $inspectStr1), $str2)
            || preg_match(sprintf('/^%s$/', $inspectStr2), $str1);
    }
}