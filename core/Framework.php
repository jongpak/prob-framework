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

        $this->dispatcher(new Request());
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

    public function dispatcher(Request $request)
    {
        $url = $this->resolveUrl($request);
        $viewModel = new ViewModel();

        $parameterMap = new ParameterMap();
        $this->bindUrlParameter($parameterMap, $url);
        $this->bindViewModelParameter($parameterMap, $viewModel);

        $returnOfController = $this->executeController($request, $parameterMap);

        $view = $this->resolveView($returnOfController);
        $this->setViewVariables($view, $viewModel->getVariables());
        $view->render();
    }

    private function resolveUrl(Request $request)
    {
        $matcher = new Matcher($this->map);
        return $matcher->match($request)['urlNameMatching'];
    }

    private function executeController(Request $request, ParameterMap $parameterMap)
    {
        $dispatcher = new Dispatcher($this->map);
        return $dispatcher->dispatch($request, $parameterMap);
    }

    /**
     * @param  mixed $returnOfController
     * @return View
     */
    private function resolveView($returnOfController)
    {
        $viewResolver = new ViewResolver($returnOfController);
        return $viewResolver->resolve($this->viewEngineConfig[$this->siteConfig['viewEngine']]);
    }

    private function bindUrlParameter(ParameterMap $map, array $url)
    {
        $map->bindByNameWithType('array', 'url', $url);

        foreach ($url as $name => $value) {
            $map->bindByName($name, $value);
        }
    }

    private function bindViewModelParameter(ParameterMap $map, ViewModel $viewModel)
    {
        $map->bindByType(ViewModel::class, $viewModel);
    }

    private function setViewVariables(View $view, array $var)
    {
        foreach ($var as $key => $value) {
            $view->set($key, $value);
        }
    }
}
