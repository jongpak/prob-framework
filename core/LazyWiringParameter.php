<?php

namespace Core;

class LazyWiringParameter
{
    private $parameterFunction;

    public function __construct(callable $parameterFunction)
    {
        $this->parameterFunction = $parameterFunction;
    }

    public function exec()
    {
        return ($this->parameterFunction)();
    }
}
