<?php

namespace App\ViewEngine;

use Core\View;

class Json implements View
{
    private $data = null;

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
