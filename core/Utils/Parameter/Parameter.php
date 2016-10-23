<?php

namespace Core\Utils\Parameter;

use Core\ParameterWire;

class Parameter
{
    public static function type($type)
    {
        return new ParameterTyped($type);
    }

    public static function name($name)
    {
        return new ParameterNamed($name);
    }

    public static function typeAndName($type, $name)
    {
        return new ParameterTypedAndNamed($type, $name);
    }

    public static function lazyCallback(callable $func)
    {
        return ParameterWire::lazyCallback($func);
    }
}

function Type($type)
{
    return Parameter::type($type);
}

function Name($type)
{
    return Parameter::name($type);
}

function TypeAndName($type, $name)
{
    return Parameter::typeAndName($type, $name);
}

function lazyCallback(callable $func)
{
    return Parameter::lazyCallback($func);
}