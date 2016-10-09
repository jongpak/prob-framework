<?php

namespace Core\ControllerDispatcher;

use PHPUnit\Framework\TestCase;
use Core\ControllerDispatcher\Dispatcher;
use Zend\Diactoros\ServerRequest;

class DispatcherTest extends TestCase
{
    public function testDispatch()
    {
        $dispatcher = new Dispatcher();
        $dispatcher->setRequest(new ServerRequest([], [], '/test'));
        $dispatcher->setRouterConfig([
            'namespace' => null,

            '/test' => function () {
                return 'test!!';
            }
        ]);

        $this->assertEquals('test!!', $dispatcher->dispatch());
    }
}
