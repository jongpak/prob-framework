<?php

namespace Core\ControllerDispatcher;

use Prob\Handler\ProcInterface;
use Prob\Handler\ParameterMap;
use Psr\Http\Message\ServerRequestInterface;
use Prob\Router\Dispatcher as RouterDispatcher;
use Prob\Router\Matcher;
use Prob\Router\Map;
use Core\ViewModel;
use Core\Application;
use Core\ViewResolver;
use Core\ViewEngineInterface;
use Core\ViewResolverInterface;

class Dispatcher
{

    /**
     * @var Map
     */
    private $routerMap;
    private $routerConfig = [];
    private $viewEngineConfig = [];

    private $viewResolvers = [];

    /**
     * @var ServerRequestInterface
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

    public function setViewResolver(array $viewResolvers)
    {
        $this->viewResolvers = $viewResolvers;
    }

    public function setRequest(ServerRequestInterface $request)
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

        if ($this->getMatchedHandler()) {
            $this->triggerEvent($this->getEventName('before'));
        }

        $result = $dispatcher->dispatch($this->request, $parameterMap);

        if ($this->getMatchedHandler()) {
            $this->triggerEvent($this->getEventName('after'));
        }

        return $result;
    }

    /**
     * @param  string $action 'before' || 'after'
     * @return string event name
     */
    private function getEventName($action)
    {
        return sprintf(
            'Controller.%s.%s',
            $this->getMatchedHandler()->getName(),
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
        $parameterMapper = new ParameterMapper();
        $parameterMapper->setRequest($this->request);
        $parameterMapper->setRouterMap($this->routerMap);

        $parameterMap = $parameterMapper->getParameterMap();

        Application::getInstance()->getEventManager()->trigger($eventName, [$parameterMap]);
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
     * @return ViewEngineInterface
     */
    private function resolveView($controllerResult)
    {
        foreach ($this->viewResolvers as $name => $resolverClassName) {
            /** @var ViewResolverInterface */
            $resolver = new $resolverClassName();
            $resolver->setViewEngineConfig(
                isset($this->viewEngineConfig[$name])
                    ? $this->viewEngineConfig[$name]
                    : []
            );

            $view = $resolver->resolve($controllerResult);

            if ($view !== null) {
                return $view;
            }
        }
    }
}
