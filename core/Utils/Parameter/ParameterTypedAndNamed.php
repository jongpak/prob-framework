<?php

namespace Core\Utils\Parameter;

use Prob\Handler\Parameter\TypedAndNamed;

class ParameterTypedAndNamed extends ParameterAbstract
{
    private $type;
    private $name;

    public function __construct($type, $name)
    {
        $this->type = $type;
        $this->name = $name;
    }

    public function value($value)
    {
        return $this->buildValue(new TypedAndNamed($this->type, $this->name), $value);
    }

    public function lazy(callable $func)
    {
        return $this->buildLazy(new TypedAndNamed($this->type, $this->name), $func);
    }
}