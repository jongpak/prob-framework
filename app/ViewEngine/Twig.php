<?php

namespace App\ViewEngine;

use Core\View;
use \Twig_Loader_Filesystem;
use \Twig_Environment;

class Twig implements View
{
    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * rendering template variables
     * @var array
     */
    private $var = [];

    public function engine($engine = [])
    {
        $loader = new Twig_Loader_Filesystem($engine['path']);
        $this->twig = new Twig_Environment($loader, $engine['settings']);
    }

    public function set($k, $v)
    {
        $this->var[$k] = $v;
    }

    public function render($fileName)
    {
        echo $this->twig->render($fileName, $this->var);
    }

}