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
     * Twig template file
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
        $loader = new Twig_Loader_Filesystem($settings['path']);
        $this->twig = new Twig_Environment($loader, $settings['settings']);

        $this->settings = $settings;
    }

    public function set($key, $value)
    {
        $this->var[$key] = $value;
    }

    public function file($fileName)
    {
        $this->templateFilename = $fileName . $this->settings['postfix'];
    }

    public function render()
    {
        echo $this->twig->render($this->templateFilename, $this->var);
    }
}
