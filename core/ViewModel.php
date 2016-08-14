<?php

namespace Core;

class ViewModel
{
    private $var = [];

    public function set($key, $value)
    {
        $this->var[$key] = $value;
    }

    public function getVariables()
    {
        return $this->var;
    }
}
