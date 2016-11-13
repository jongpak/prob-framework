<?php

namespace Core;

use Core\Utils\Parameter\Parameter;
use PHPUnit\Framework\TestCase;
use Prob\Handler\Parameter\Named;
use Prob\Handler\Parameter\Typed;
use Prob\Handler\Parameter\TypedAndNamed;
use Prob\Handler\ParameterMap;
use Prob\Handler\Proc\ClosureProc;

class ParameterWireTest extends TestCase
{
    public function testWiring()
    {
        $map = new ParameterMap();

        ParameterWire::appendParameter(new Named('test'), 'hello!');
        ParameterWire::appendParameter(new Typed('array'), ['hello', 'world']);
        ParameterWire::appendParameter(new TypedAndNamed('array', 'namedArray'), ['php']);
        ParameterWire::injectParameter($map);

        $proc = new ClosureProc(function($test, array $dummy, array $namedArray) {
            return [$test, $dummy, $namedArray];
        });

        $this->assertEquals(['hello!', ['hello', 'world'], ['php']], $proc->execWithParameterMap($map));
    }

    public function testLazyCallbackFactory()
    {
        $callback = ParameterWire::lazyCallback(function() {
            return 'test';
        });

        $this->assertEquals(true, $callback instanceof LazyWiringParameterCallback);
        $this->assertEquals('test', $callback->exec());
    }

    public function testLazyParameterFactory()
    {
        $param = ParameterWire::lazy(function() {
            return 'test';
        });

        $this->assertEquals(true, $param instanceof LazyWiringParameter);
        $this->assertEquals('test', $param->exec());
    }

    public function testLazyCallbackWiring()
    {
        $map = new ParameterMap();

        ParameterWire::appendParameterCallback(ParameterWire::lazyCallback(function() {
            return [
                Parameter::name('name')->value('name!'),
            ];
        }));
        ParameterWire::injectParameter($map);

        $proc = new ClosureProc(function($name) {
            return $name;
        });

        $this->assertEquals('name!', $proc->execWithParameterMap($map));
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
