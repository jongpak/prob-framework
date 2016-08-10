<?php

namespace app\ViewEngine;

use Core\View;

class Json implements View
{
    private $data = null;

    public function engine($setting = [])
    {
        // dummy
    }

    public function set($k, $v)
    {
        // dummy
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