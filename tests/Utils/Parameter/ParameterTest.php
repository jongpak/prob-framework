<?php

use Core\LazyWiringParameterCallback;
use Core\Utils\Parameter\Parameter;
use Core\Utils\Parameter\ParameterNamed;
use Core\Utils\Parameter\ParameterTyped;
use Core\Utils\Parameter\ParameterTypedAndNamed;
use PHPUnit\Framework\TestCase;

class ParameterTest extends TestCase
{
    public function testTypeFactory()
    {
        $this->assertTrue(Parameter::type('array') instanceof ParameterTyped);
    }

    public function testNameFactory()
    {
        $this->assertTrue(Parameter::name('name') instanceof ParameterNamed);
    }

    public function testTypeAndNameFactory()
    {
        $this->assertTrue(Parameter::typeAndName('array', 'name') instanceof ParameterTypedAndNamed);
    }

    public function testLazyCallbackFactory()
    {
        $this->assertTrue(Parameter::lazyCallback(function() {}) instanceof LazyWiringParameterCallback);
    }
}