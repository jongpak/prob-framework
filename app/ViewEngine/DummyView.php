<?php

namespace App\ViewEngine;

use Core\View;

class DummyView implements View
{
    public function engine($setting = [])
    {
        // dummy
    }

    public function set($key, $value)
    {
        // dummy
    }

    public function file($fileName)
    {
        // dummy
    }

    public function render()
    {
        // dummy
    }

}