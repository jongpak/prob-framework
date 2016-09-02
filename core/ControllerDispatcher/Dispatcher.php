<?php

namespace Core\ControllerDispatcher;

use Prob\Handler\ProcInterface;
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

        $result = $this->execute($parameterMap);
        $this->renderView($result, $viewModel);
    }

    private function buildRouterMap()
    {
        $builder = new RouterMapBuilder();
        $builder->setRouterConfig($this->routerConfig);

        $this->routerMap = $builder->build();
    }

    /**
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


    private function execute(ParameterMap $parameterMap)
    {
        $dispatcher = new RouterDispatcher($this->routerMap);

        /**
         * TODO 클로저와 일반함수 형태에서도 컨트롤러 이벤트가 작동하도록 수정해야함.
         */

        $this->triggerEvent($this->getEventName('before'));
        $result = $dispatcher->dispatch($this->request, $parameterMap);
        $this->triggerEvent($this->getEventName('after'));

        return $result;
    }

    private function getEventName($action)
    {
        $token = explode('.', $this->getMatchedHandler()->getName());
        return sprintf('Controller.%s.%s.%s',
                            $token[0],
                            $token[1],
                            $action
        );
    }

    /**
     * @return ProcInterface
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

    private function renderView($controllerResult, ViewModel $viewModel)
    {
        $view = $this->resolveView($controllerResult);

        foreach ($viewModel->getVariables() as $key => $value) {
            $view->set($key, $value);
        }

        $view->render();
    }

    /**
     * @param  mixed $controllerResult
     * @return View
     */
    private function resolveView($controllerResult)
    {
        $viewResolver = new ViewResolver($controllerResult);
        return $viewResolver->resolve($this->viewEngineConfig);
    }
}
