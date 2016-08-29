<?php

namespace Core\ControllerDispatcher;

use Prob\Handler\Proc;
use Prob\Handler\ParameterMap;
use Prob\Router\Dispatcher as RouterDispatcher;
use Prob\Rewrite\Request;
use Prob\Router\Matcher;
use Prob\Router\Map;
use Core\ViewModel;
use Core\Application;
use Core\ViewResolver;

class Dispatcher
{

    /**
     * @var Map
     */
    private $routerMap;
    private $routerConfig = [];
    private $viewEngineConfig = [];

    /**
     * @var Request
     */
    private $request;

    public function setRouterConfig(array $routerConfig)
    {
        $this->routerConfig = $routerConfig;
    }

    public function setViewEngineConfig(array $config)
    {
        $this->viewEngineConfig = $config;
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function dispatch()
    {
        $this->buildRouterMap();

        $viewModel = new ViewModel();
        $parameterMap = $this->getParameterMap($viewModel);

        $returnOfController = $this->executeController($parameterMap);

        $this->renderView($returnOfController, $viewModel);
    }

    private function buildRouterMap()
    {
        $builder = new RouterMapBuilder();
        $builder->setRouterConfig($this->routerConfig);

        $this->routerMap = $builder->build();
    }

    /**
     * @param  Request   $request   [description]
     * @param  ViewModel $viewModel [description]
     * @return ParameterMap
     */
    private function getParameterMap(ViewModel $viewModel)
    {
        $parameterMapper = new ParameterMapper();

        $parameterMapper->setRequest($this->request);
        $parameterMapper->setViewModel($viewModel);
        $parameterMapper->setRouterMap($this->routerMap);

        return $parameterMapper->getParameterMap();
    }


    private function executeController(ParameterMap $parameterMap)
    {
        $dispatcher = new RouterDispatcher($this->routerMap);

        /**
         * TODO 클로저와 일반함수 형태에서도 컨트롤러 이벤트가 작동하도록 수정해야함.
         */

        $this->triggerEvent($this->getControllerEventName() . '.before');
        $result = $dispatcher->dispatch($this->request, $parameterMap);
        $this->triggerEvent($this->getControllerEventName() . '.after');

        return $result;
    }

    private function getControllerEventName()
    {
        $handlerResolvedName = $this->getMatchedHandler()->getResolvedName();
        return 'Controller.' . $handlerResolvedName['class'] . '.' . $handlerResolvedName['func'];
    }

    /**
     * @return Proc
     */
    private function getMatchedHandler()
    {
        $matcher = new Matcher($this->routerMap);
        return $matcher->match($this->request)['handler'];
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
