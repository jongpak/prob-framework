<?php

namespace App\Bootstrap\Test;

use Core\ParameterWire;
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
                ]
            ]
        ]);

        $map = new ParameterMap();
        ParameterWire::injectParameter($map);

        $proc = new ClosureProc(function($test) {
            return $test;
        });

        $this->assertEquals('hello!', $proc->execWithParameterMap($map));
    }
}
