<?php

namespace Core\ControllerDispatcher;

use PHPUnit\Framework\TestCase;
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
}
