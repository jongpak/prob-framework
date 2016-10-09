<?php

namespace Core\ControllerDispatcher;

use Prob\Handler\ProcInterface;
use Prob\Handler\ParameterMap;
use Psr\Http\Message\ServerRequestInterface;
use Prob\Router\Dispatcher as RouterDispatcher;
use Prob\Router\Matcher;
use Prob\Router\Map;
use Core\ViewModel;

class Dispatcher
{
    /**
     * @var Map
     */
    private $routerMap;
    private $routerConfig = [];

    /**
     * @var ViewModel
     */
    private $viewModel;

    /**
     * @var ServerRequestInterface
     */
    private $request;

    public function __construct()
    {
        $this->viewModel = new ViewModel();
    }

    public function setRouterConfig(array $routerConfig)
    {
        $this->routerConfig = $routerConfig;
    }

    public function setRequest(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    public function getViewModel()
    {
        return $this->viewModel;
    }

    public function dispatch()
    {
        $this->buildRouterMap();
        $parameterMap = $this->getParameterMap();
        $dispatcher = new RouterDispatcher($this->routerMap);

        /**
         * TODO 클로저와 일반함수 형태에서도 컨트롤러 이벤트가 작동하도록 수정해야함.
         */

        ControllerEvent::triggerEvent($this->getController()->getName(), 'before', [$parameterMap]);

        $result = $dispatcher->dispatch($this->request, $parameterMap);

        ControllerEvent::triggerEvent($this->getController()->getName(), 'after', [$parameterMap]);

        return $result;
    }

    private function buildRouterMap()
    {
        $builder = new RouterMapBuilder();
        $builder->setRouterConfig($this->routerConfig);

        $this->routerMap = $builder->build();
    }

    /**
     * @return ParameterMap
     */
    private function getParameterMap()
    {
        $parameterMapper = new ParameterMapper();

        $parameterMapper->setRequest($this->request);
        $parameterMapper->setViewModel($this->viewModel);
        $parameterMapper->setRouterMap($this->routerMap);

        return $parameterMapper->getParameterMap();
    }

    /**
     * @return ProcInterface
     */
    private function getController()
    {
        $matcher = new Matcher($this->routerMap);
        return $matcher->match($this->request)['handler'];
    }
}
