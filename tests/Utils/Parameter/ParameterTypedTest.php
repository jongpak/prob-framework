<?php

namespace Core\Utils\Parameter;

use PHPUnit\Framework\TestCase;
use Prob\Handler\Parameter\Typed;

class ParameterTypedTest extends TestCase
{
    public function testFactory()
    {
        $typed = new ParameterTyped('array');
        $this->assertEquals(
            [
                'key' => new Typed('array'),
                'value' => ['value']
            ],
            $typed->value(['value'])
        );
    }

    public function testLazyFactory()
    {
        $value = [];

        $named = new ParameterTyped('test');
        $this->assertEquals(
            ['test'],
            ($named->lazy(function() use ($value) {
                $value[] = 'test';
                return $value;
            }))['value']->exec()
        );
    }
}