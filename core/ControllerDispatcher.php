<?php

namespace Core;

use Prob\Handler\Proc;
use Prob\Handler\ParameterMap;
use Prob\Router\Dispatcher;
use Prob\Rewrite\Request;
use Prob\Router\Matcher;
use Prob\Router\Map;

class ControllerDispatcher
{

    /**
     * @var Map
     */
    private $routerMap;
    private $routerConfig = [];
    private $viewEngineConfig = [];

    public function setRouterConfig(array $routerConfig)
    {
        $this->routerConfig = $routerConfig;
    }

    public function setViewEngineConfig(array $config)
    {
        $this->viewEngineConfig = $config;
    }

    public function dispatch(Request $request)
    {
        $this->buildRouterMap();

        $viewModel = new ViewModel();
        $parameterMap = $this->getControllerParameterMap($request, $viewModel);

        $returnOfController = $this->executeController($request, $parameterMap);

        $this->renderView($returnOfController, $viewModel);
    }

    private function buildRouterMap()
    {
        $builder = new RouterMapBuilder();
        $builder->setRouterConfig($this->routerConfig);

        $this->routerMap = $builder->build();
    }

    private function getControllerParameterMap(Request $request, ViewModel $viewModel)
    {
        $url = $this->resolveUrl($request);

        $parameterMap = new ParameterMap();
        $this->bindUrlParameter($parameterMap, $url);
        $this->bindViewModelParameter($parameterMap, $viewModel);

        return $parameterMap;
    }

    private function resolveUrl(Request $request)
    {
        $matcher = new Matcher($this->routerMap);
        return $matcher->match($request)['urlNameMatching'] ?: [];
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


    private function executeController(Request $request, ParameterMap $parameterMap)
    {
        $dispatcher = new Dispatcher($this->routerMap);
        $handlerResolvedName = $this->getMatchedHandler($request)->getResolvedName();

        $this->triggerEvent('Controller.' . $handlerResolvedName['class'] . '.' . $handlerResolvedName['func'] . '.before');
        $result = $dispatcher->dispatch($request, $parameterMap);
        $this->triggerEvent('Controller.' . $handlerResolvedName['class'] . '.' . $handlerResolvedName['func'] . '.after');

        return $result;
    }

    /**
     * @return Proc
     */
    private function getMatchedHandler(Request $request)
    {
        $matcher = new Matcher($this->routerMap);
        return $matcher->match($request)['handler'];
    }

    private function triggerEvent($eventName)
    {
        Application::getInstance()
            ->getEventManager()
                ->trigger($eventName);
    }

    private function renderView($returnOfController, ViewModel $viewModel)
    {
        $view = $this->resolveView($returnOfController);

        foreach ($viewModel->getVariables() as $key => $value) {
            $view->set($key, $value);
        }

        $view->render();
    }

    /**
     * @param  mixed $returnOfController
     * @return View
     */
    private function resolveView($returnOfController)
    {
        $viewResolver = new ViewResolver($returnOfController);
        return $viewResolver->resolve($this->viewEngineConfig);
    }
}
