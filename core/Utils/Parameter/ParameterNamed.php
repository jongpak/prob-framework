<?php

namespace Core\Utils\Parameter;

use Prob\Handler\Parameter\Named;

class ParameterNamed extends ParameterAbstract
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function value($value)
    {
        return $this->buildValue(new Named($this->name), $value);
    }

    public function lazy(callable $func)
    {
        return $this->buildLazy(new Named($this->name), $func);
    }
}