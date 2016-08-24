<?php

namespace App\ViewEngine;

use Core\View;

class Redirect implements View
{

    private $url = '';

    public function init($setting = [])
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

    public function file($url)
    {
        $this->url = $url;
    }

    public function getFile()
    {
        return $this->url;
    }

    public function render()
    {
        header('location: ' . $this->url);
    }
}
