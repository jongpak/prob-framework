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
        $matchingUrl = $matcher->match(new Request());

        $viewModel = new ViewModel();
        $parameterMap = new ParameterMap();
        $this->bindControllerParameters($parameterMap, $matchingUrl['urlNameMatching'], $viewModel);

        $dispatcher = new Dispatcher($this->map);
        $returnOfController = $dispatcher->dispatch(new Request(), $parameterMap);
        $viewResolver = new ViewResolver($returnOfController);

        /** @var View $view */
        $view = $viewResolver->resolve($this->viewEngineConfig[$this->siteConfig['viewEngine']]);
        $this->setViewVariables($view, $viewModel->getVariables());
        $view->render();
    }

    private function bindControllerParameters(ParameterMap $map, array $url, ViewModel $viewModel)
    {
        foreach ($url as $name => $value) {
            $map->bindByName($name, $value);
        }

        $map->bindByNameWithType('array', 'url', $url);
        $map->bindByType(ViewModel::class, $viewModel);
    }

    private function setViewVariables(View $view, array $var)
    {
        foreach ($var as $key => $value) {
            $view->set($key, $value);
        }
    }
}
