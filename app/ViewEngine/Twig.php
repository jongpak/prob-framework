<?php

namespace App\ViewEngine;

use Core\View;
use Core\Application;
use \Twig_Loader_Filesystem;
use \Twig_Environment;
use \Twig_SimpleFunction;

class Twig implements View
{

    private $PUBLIC_PATH = 'public/';

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

        $this->addCssFunction();
        $this->addAssetFunction();
        $this->addUrlFunction();
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
        $this->templateFilename = $fileName . $this->settings['postfix'];
    }

    public function getFile()
    {
        return $this->templateFilename;
    }

    public function render()
    {
        echo $this->twig->render($this->templateFilename, $this->var);
    }

    private function addCssFunction()
    {
        $function = new Twig_SimpleFunction('css', function ($url) {
            return sprintf('<link rel="stylesheet" type="text/css" href="%s">', $url);
        }, ['is_safe' => ['html']]);

        $this->twig->addFunction($function);
    }

    private function addAssetFunction()
    {
        $this->twig->addFunction(new Twig_SimpleFunction('asset', function ($file) {
            return Application::getInstance()->url($this->PUBLIC_PATH . $file);
        }));
    }

    private function addUrlFunction()
    {
        $this->twig->addFunction(new Twig_SimpleFunction('url', function ($url = '') {
            return Application::getInstance()->url($url);
        }));
    }
}
