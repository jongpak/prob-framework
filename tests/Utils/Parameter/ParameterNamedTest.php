<?php

namespace Core\Utils\Parameter;

use PHPUnit\Framework\TestCase;
use Prob\Handler\Parameter\Named;

class ParameterNamedTest extends TestCase
{
    public function testFactory()
    {
        $named = new ParameterNamed('test');
        $this->assertEquals(
            [
                'key' => new Named('test'),
                'value' => 'value'
            ],
            $named->value('value')
        );
    }

    public function testLazyFactory()
    {
        $value = 50;

        $named = new ParameterNamed('test');
        $this->assertEquals(
            51,
            ($named->lazy(function() use ($value) {
                return ++$value;
            }))['value']->exec()
        );
    }
}