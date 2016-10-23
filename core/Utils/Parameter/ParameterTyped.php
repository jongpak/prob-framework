<?php

namespace Core\Utils\Parameter;

use Prob\Handler\Parameter\Typed;

class ParameterTyped extends ParameterAbstract
{
    private $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function value($value)
    {
        return $this->buildValue(new Typed($this->type), $value);
    }

    public function lazy(callable $func)
    {
        return $this->buildLazy(new Typed($this->type), $func);
    }
}