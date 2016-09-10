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

        $this->assertEquals(2, count($map->getHandlers('GET')));
        $this->assertEquals('/', $map->getHandlers('GET')[0]['urlPattern']);
        $this->assertEquals('/test', $map->getHandlers('GET')[1]['urlPattern']);

        $this->assertEquals(1, count($map->getHandlers('POST')));
        $this->assertEquals('/', $map->getHandlers('POST')[0]['urlPattern']);
    }
}
