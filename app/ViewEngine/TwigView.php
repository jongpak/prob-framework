<?php

namespace App\ViewEngine;

use Core\View\ViewEngineInterface;
use Core\Application;
use \Twig_Loader_Filesystem;
use \Twig_Environment;
use \Twig_SimpleFunction;

class TwigView implements ViewEngineInterface
{
    /**
     * @var Twig_Environment
     */
    protected $twig;

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

    public function __construct($settings = [])
    {
        $loader = new Twig_Loader_Filesystem($settings['path']);
        $this->twig = new Twig_Environment($loader, $settings['settings']);

        $this->settings = $settings;

        $this->initCustomFunction();
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
        return $this->twig->render($this->templateFilename, $this->var);
    }

    private function initCustomFunction() {
        $this->addCssFunction();
        $this->addAssetFunction();
        $this->addUrlFunction();
        $this->addFileFunction();
    }

    private function addCssFunction()
    {
        $this->twig->addFunction(new Twig_SimpleFunction(
            'css',
            [$this, 'cssFunction'],
            ['is_safe' => ['html']]
        ));
    }

    private function addAssetFunction()
    {
        $this->twig->addFunction(new Twig_SimpleFunction(
            'asset',
            [$this, 'assetFunction']
        ));
    }

    private function addUrlFunction()
    {
        $this->twig->addFunction(new Twig_SimpleFunction(
            'url',
            [$this, 'urlFunction']
        ));
    }

    private function addFileFunction()
    {
        $this->twig->addFunction(new Twig_SimpleFunction(
            'file',
            [$this, 'fileFunction']
        ));
    }

    public function cssFunction($url)
    {
        return sprintf('<link rel="stylesheet" type="text/css" href="%s">', $url);
    }

    public function assetFunction($file)
    {
        return Application::getPublicUrl($file);
    }

    public function urlFunction($url = '')
    {
        return Application::getUrl($url);
    }

    public function fileFunction($file)
    {
        $pos = strrpos($this->getFile(), '/');

        if($pos === false) {
            return $file . $this->settings['postfix'];
        }

        return substr($this->getFile(), 0, $pos) . '/' . $file . $this->settings['postfix'];
    }
}
