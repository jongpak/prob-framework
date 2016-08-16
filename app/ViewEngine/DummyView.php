<?php

namespace App\ViewEngine;

use Core\View;

class DummyView implements View
{
    public function init($setting = [])
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
