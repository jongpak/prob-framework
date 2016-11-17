<?php

namespace Core\ControllerDispatcher;

use PHPUnit\Framework\TestCase;
use Prob\Handler\Parameter\Named;
use Prob\Handler\ParameterMap;
use Prob\Router\Exception\RoutePathNotFound;
use Prob\Router\Map;
use Zend\Diactoros\ServerRequest;

class DispatcherTest extends TestCase
{
    public function testDispatch()
    {
        $request = new ServerRequest([], [], '/test');
        $routerMap = (new RouterMapBuilder([
            'namespace' => null,
            '/test' => function () {
                return 'test!!';
            }
        ]))->build();

        RequestMatcher::setRequest($request);
        RequestMatcher::setRouterMap($routerMap);

        $dispatcher = new Dispatcher();
        $dispatcher->setRequest($request);
        $dispatcher->setRouterMap($routerMap);

        $this->assertEquals('test!!', $dispatcher->dispatch());
    }

    public function testDispatchWithParameter()
    {
        $request = new ServerRequest([], [], '/test');
        $routerMap = (new RouterMapBuilder([
            'namespace' => null,
            '/test' => function ($arg) {
                return $arg;
            }
        ]))->build();
        $parameterMap = new ParameterMap();
        $parameterMap->bindBy(new Named('arg'), 'test!!');

        RequestMatcher::setRequest($request);
        RequestMatcher::setRouterMap($routerMap);

        $dispatcher = new Dispatcher();
        $dispatcher->setRequest($request);
        $dispatcher->setRouterMap($routerMap);
        $dispatcher->setParameterMap($parameterMap);

        $this->assertEquals('test!!', $dispatcher->dispatch());
    }

    public function testRouteNotExists()
    {
        $request = new ServerRequest([], [], '/NOT_FOUND');
        $routerMap = (new RouterMapBuilder([
            'namespace' => null,

            '/test' => function () { }
        ]))->build();

        RequestMatcher::setRequest($request);
        RequestMatcher::setRouterMap($routerMap);

        $dispatcher = new Dispatcher();
        $dispatcher->setRequest($request);
        $dispatcher->setRouterMap($routerMap);

        $this->expectException(RoutePathNotFound::class);
        $dispatcher->dispatch();
    }
}
