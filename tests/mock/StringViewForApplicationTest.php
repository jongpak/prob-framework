<?php

namespace App\ViewEngine;

class StringViewForApplicationTest extends DummyView
{

    private $templateFilename = '';
    private $var = [];

    public function set($key, $value)
    {
        $this->var[$key] = $value;
    }

    public function file($fileName)
    {
        $this->templateFilename = $fileName;
    }

    public function getRenderingResult()
    {
        return $this->templateFilename . ' -- ' . $this->var['key'];
    }

    public function render()
    {
        echo $this->getRenderingResult();
    }
}
