<?php

namespace Core;

use Prob\Handler\ParameterMap;
use Prob\Router\Dispatcher;
use Prob\Rewrite\Request;
use Prob\Router\Matcher;

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
        $matcher = new Matcher($this->map);
        $matchUrl = $matcher->match(new Request());

        $viewModel = new ViewModel();

        $parameterMap = new ParameterMap();

        foreach ($matchUrl['urlNameMatching'] as $name => $value) {
            $parameterMap->bindByName($name, $value);
        }

        $parameterMap->bindByNameWithType('array', 'url', $matchUrl['urlNameMatching']);
        $parameterMap->bindByType(ViewModel::class, $viewModel);

        $dispatcher = new Dispatcher($this->map);
        $returnOfController = $dispatcher->dispatch(new Request(), $parameterMap);

        $viewResolver = new ViewResolver($returnOfController);

        /** @var View $view */
        $view = $viewResolver->resolve($this->viewEngineConfig[$this->siteConfig['viewEngine']]);

        foreach ($viewModel->getVariables() as $key => $value) {
            $view->set($key, $value);
        }

        $view->render();
    }
}
