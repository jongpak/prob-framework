<?php

namespace Core;

use PHPUnit\Framework\TestCase;
use Prob\Handler\Parameter\Named;
use Prob\Handler\ParameterMap;
use Prob\Handler\Proc\ClosureProc;

class ParameterWireTest extends TestCase
{
    public function testWiring()
    {
        $map = new ParameterMap();

        ParameterWire::appendParameter(new Named('test'), 'hello!');
        ParameterWire::injectParameter($map);

        $proc = new ClosureProc(function($test) {
            return $test;
        });

        $this->assertEquals('hello!', $proc->execWithParameterMap($map));
    }

    public function testLazyWiring()
    {
        $map = new ParameterMap();

        ParameterWire::appendParameter(new Named('test'), ParameterWire::lazy(function() {
            return 'lazy!';
        }));
        ParameterWire::injectParameter($map);

        $proc = new ClosureProc(function($test) {
            return $test;
        });

        $this->assertEquals('lazy!', $proc->execWithParameterMap($map));
    }
}
