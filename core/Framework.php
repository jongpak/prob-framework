<?php

namespace Core;

use Prob\Router\Dispatcher;
use Prob\Rewrite\Request;

class Framework
{
    private $map;
    private $siteConfig = [];
    private $viewEngineConfig = [];

    public function boot()
    {
        $this->setOptionDisplayError();

        $this->loadSiteConfig();
        $this->loadViewEngineConfig();
        $this->loadRouterMap();

        $this->dispatcher();
    }

    public function setOptionDisplayError()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 'on');
    }

    public function loadRouterMap()
    {
        $this->map = require '../config/router.php';
    }

    public function loadSiteConfig()
    {
        $this->siteConfig = require '../config/site.php';
    }

    public function loadViewEngineConfig()
    {
        $this->viewEngineConfig = require '../config/viewEngine.php';
    }

    public function dispatcher()
    {
        $returnValueOfController = null;

        $dispatcher = new Dispatcher($this->map);
        $returnValueOfController = $dispatcher->dispatch(new Request());

        $viewResolver = new ViewResolver($returnValueOfController);
        $view = $viewResolver->resolve($this->viewEngineConfig[$this->siteConfig['viewEngine']]);
        $view->render();
    }
}