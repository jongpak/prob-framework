<?php

namespace App\Bootstrap\Test;

use Core\ParameterWire;
use Core\Utils\Parameter\Parameter;
use PHPUnit\Framework\TestCase;
use Core\Bootstrap\Bootstrap;
use Prob\Handler\Parameter\Named;
use Prob\Handler\ParameterMap;
use Prob\Handler\Proc\ClosureProc;

class ParameterWiringBootstrap extends TestCase
{
    public function testBoot()
    {
        $bootstrap = new Bootstrap([
            'App\\Bootstrap\\ParameterWiringBootstrap',
        ]);
        $bootstrap->boot([
            'parameter' => [
                [
                    'key' => new Named('test'),
                    'value' => 'hello!'
                ],
                ParameterWire::lazyCallback(function() {
                    return [
                        [
                            'key' => new Named('test2'),
                            'value' => 'world!'
                        ]
                    ];
                })
            ]
        ]);

        $map = new ParameterMap();
        ParameterWire::injectParameter($map);

        $proc = new ClosureProc(function($test, $test2) {
            return $test.$test2;
        });

        $this->assertEquals('hello!world!', $proc->execWithParameterMap($map));
    }
}
