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
        $quotedStr1 = preg_quote($str1);
        $quotedStr2 = preg_quote($str2);

        $inspectStr1 = str_replace('\\*', '.*', $quotedStr1);
        $inspectStr2 = str_replace('\\*', '.*', $quotedStr2);

        return preg_match(sprintf('/^%s$/', $inspectStr1), $str2)
            || preg_match(sprintf('/^%s$/', $inspectStr2), $str1);
    }
}