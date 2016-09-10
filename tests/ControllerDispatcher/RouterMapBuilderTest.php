<?php

namespace Core\ControllerDispatcher;

use PHPUnit\Framework\TestCase;

class RouterMapBuilderTest extends TestCase
{

    public function testBuild()
    {
        $routerMapBuilder = new RouterMapBuilder();
        $routerMapBuilder->setRouterConfig([
            'namespace' => 'App\\Controller',

            '/' => [
                'GET' => function () {
                    echo '[GET] index';
                },
                'POST' => function () {
                    echo '[POST] index';
                }
            ],
            '/test' => function () {
                echo '[GET] test';
            }
        ]);

        $map = $routerMapBuilder->build();

        $this->assertEquals(2, count($map->getHandlerByMethod('GET')));
        $this->assertEquals('/', $map->getHandlerByMethod('GET')[0]->getUrlPattern());
        $this->assertEquals('/test', $map->getHandlerByMethod('GET')[1]->getUrlPattern());

        $this->assertEquals(1, count($map->getHandlerByMethod('POST')));
        $this->assertEquals('/', $map->getHandlerByMethod('POST')[0]->getUrlPattern());
    }
}
