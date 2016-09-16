<?php

namespace Core;

use Prob\Handler\ParameterMap;
use Prob\Handler\ParameterInterface;

class ParameterWire
{
    private static $parameters = [];

    public static function appendParameter(ParameterInterface $key, $value)
    {
        self::$parameters[] = [
            'key' => $key,
            'value' => $value
        ];
    }

    public static function injectParameter(ParameterMap $map)
    {
        foreach (self::$parameters as $v) {
            $value = $v['value'] instanceof LazyWiringParameter ? $v['value']->exec() : $v['value'];
            $map->bindBy($v['key'], $value);
        }

        return $map;
    }

    public static function post(callable $parameter)
    {
        return new LazyWiringParameter($parameter);
    }
}
