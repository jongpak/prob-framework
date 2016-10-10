<?php

namespace Core\ControllerDispatcher;

use Prob\Handler\ProcInterface;
use Prob\Handler\ParameterMap;
use Psr\Http\Message\ServerRequestInterface;
use Prob\Router\Dispatcher as RouterDispatcher;
use Prob\Router\Matcher;
use Prob\Router\Map;

class Dispatcher
{
    /**
     * @var Map
     */
    private $routerMap;

    /**
     * @var ParameterMap
     */
    private $parameterMap;

    /**
     * @var ServerRequestInterface
     */
    private $request;

    public function setRouterMap(Map $routerMap)
    {
        $this->routerMap = $routerMap;
    }

    public function setRequest(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    public function setParameterMap(ParameterMap $parameterMap)
    {
        $this->parameterMap = $parameterMap;
    }

    public function dispatch()
    {
        $dispatcher = new RouterDispatcher($this->routerMap);

        /**
         * TODO 클로저와 일반함수 형태에서도 컨트롤러 이벤트가 작동하도록 수정해야함.
         */

        $this->triggerEvent('before');

        $result = $dispatcher->dispatch($this->request, $this->parameterMap);

        $this->triggerEvent('after');

        return $result;
    }

    private function triggerEvent($operation)
    {
        ControllerEvent::triggerEvent(
            RequestMatcher::getControllerProc()->getName(),
            $operation,
            [$this->parameterMap]
        );
    }
}
