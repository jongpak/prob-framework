<?php

namespace app\ViewEngine;

use Core\View;

class Json implements View
{
    private $data = null;

    public function engine($setting = [])
    {
        // JSON
    }

    public function set($k, $v)
    {
        // JSON
    }

    public function file($data)
    {
        $this->data = $data;
    }

    public function render()
    {
        echo json_encode($this->data);
    }

}