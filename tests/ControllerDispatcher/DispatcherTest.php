<?php

namespace Core\ControllerDispatcher;

use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;

class DispatcherTest extends TestCase
{
    public function testDispatch()
    {
        $dispatcher = new Dispatcher();
        $dispatcher->setRequest(new ServerRequest([], [], '/test'));
        $dispatcher->setRouterMap((new RouterMapBuilder([
            'namespace' => null,

            '/test' => function () {
                return 'test!!';
            }
        ]))->build());

        $this->assertEquals('test!!', $dispatcher->dispatch());
    }
}
