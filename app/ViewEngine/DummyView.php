<?php

namespace App\ViewEngine;

use Core\ViewEngineInterface;

class DummyView implements ViewEngineInterface
{
    public function __construct($settings = [])
    {
        // dummy
    }

    public function set($key, $value)
    {
        // dummy
    }

    public function getVariables()
    {
        return [];
    }

    public function file($fileName)
    {
        // dummy
    }

    public function getFile()
    {
        return null;
    }

    public function render()
    {
        // dummy
    }
}
