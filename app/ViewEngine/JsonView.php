<?php

namespace App\ViewEngine;

use Core\View\ViewEngineInterface;

class JsonView implements ViewEngineInterface
{
    private $data = null;

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

    public function file($data)
    {
        $this->data = $data;
    }

    public function getFile()
    {
        return $this->data;
    }

    public function render()
    {
        header('Content-Type: application/json');
        echo json_encode($this->data);
    }
}
