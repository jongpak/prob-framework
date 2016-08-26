<?php

namespace App\ViewEngine;

use Core\View;

class StringViewForTest implements View
{


    /**
     * template file
     *
     * @var string
     */
    private $templateFilename = '';

    /**
     * @var array engine setting
     */
    private $settings = [];

    /**
     * rendering template variables
     * @var array
     */
    private $var = [];

    public function init($settings = [])
    {
        $this->settings = $settings;
    }

    public function set($key, $value)
    {
        $this->var[$key] = $value;
    }

    public function getVariables()
    {
        return $this->var;
    }

    public function file($fileName)
    {
        $this->templateFilename = $fileName;
    }

    public function getFile()
    {
        return $this->templateFilename;
    }

    public function render()
    {
        echo $this->var['key'];
    }
}
