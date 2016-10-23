<?php

namespace Core\Utils\Parameter;

use Core\ParameterWire;

abstract class ParameterAbstract
{
    abstract public function value($value);
    abstract public function lazy(callable $func);

    protected function buildValue($key, $value)
    {
        return [
            'key' => $key,
            'value' => $value
        ];
    }

    protected function buildLazy($key, $value)
    {
        return [
            'key' => $key,
            'value' => ParameterWire::lazy($value)
        ];
    }
}