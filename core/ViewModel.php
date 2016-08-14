<?php

namespace Core;

class ViewModel
{
    /**
     * @var array
     */
    private $var = [];

    public function set($key, $value)
    {
        $this->var[$key] = $value;
    }

    /**
     * Return array of view variables
     * @return array
     */
    public function getVariables()
    {
        return $this->var;
    }
}
