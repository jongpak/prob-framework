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

    public static function appendParameterCallback(LazyWiringParameterCallback $callback)
    {
        self::$parameters[] = $callback;
    }

    public static function injectParameter(ParameterMap $map)
    {
        $buildedParameters = self::makeParameter();

        foreach ($buildedParameters as $v) {
            $value = $v['value'] instanceof LazyWiringParameter ? $v['value']->exec() : $v['value'];
            $map->bindBy($v['key'], $value);
        }

        return $map;
    }

    private static function makeParameter()
    {
        $buildedParameters = [];

        foreach (self::$parameters as $v) {
            if ($v instanceof LazyWiringParameterCallback) {
                $buildedParameters = array_merge($buildedParameters, $v->exec());
                continue;
            }

            $buildedParameters[] = $v;
        }

        return $buildedParameters;
    }

    public static function postCallback(callable $func)
    {
        return new LazyWiringParameterCallback($func);
    }

    public static function post(callable $parameter)
    {
        return new LazyWiringParameter($parameter);
    }
}
