<?php

namespace Core;

use Prob\Handler\ParameterMap;
use Prob\Router\Dispatcher;
use Prob\Rewrite\Request;
use Prob\Router\Map;
use Prob\Router\Matcher;

class Framework
{
    private $map;
    private $siteConfig = [];
    private $viewEngineConfig = [];

    private function __construct()
    {
    }

    /**
     * @return Framework
     */
    public static function getInstance()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new self();
        }

        return $instance;
    }

    public function boot()
    {
        $this->setDisplayError();

        $this->setSiteConfig(require '../config/site.php');
        $this->setViewEngineConfig(require '../config/viewEngine.php');
        $this->setRouterMap(require '../config/router.php');

        $this->dispatcher(new Request());
    }

    public function setDisplayError($isDisplay = true)
    {
        error_reporting(E_ALL);
        ini_set('display_errors', $isDisplay);
    }

    public function setRouterMap(Map $routeMap)
    {
        $this->map = $routeMap;
    }

    public function setSiteConfig(array $siteConfig)
    {
        $this->siteConfig = $siteConfig;
    }

    public function setViewEngineConfig(array $viewEngineConfig)
    {
        $this->viewEngineConfig = $viewEngineConfig;
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
        return $matcher->match($request)['urlNameMatching'] ?: [];
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
