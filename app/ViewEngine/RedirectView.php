<?php

namespace App\ViewEngine;

use Core\View\ViewEngineInterface;

class RedirectView implements ViewEngineInterface
{
    private $url = '';

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
