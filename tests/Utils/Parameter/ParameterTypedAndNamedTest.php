<?php

namespace Core\Utils\Parameter;

use PHPUnit\Framework\TestCase;
use Prob\Handler\Parameter\TypedAndNamed;

class ParameterTypedAndNamedTest extends TestCase
{
    public function testFactory()
    {
        $typedAndNamed = new ParameterTypedAndNamed('array', 'name');
        $this->assertEquals(
            [
                'key' => new TypedAndNamed('array', 'name'),
                'value' => ['value']
            ],
            $typedAndNamed->value(['value'])
        );
    }

    public function testLazyFactory()
    {
        $value = [];

        $named = new ParameterTypedAndNamed('array', 'test');
        $this->assertEquals(
            ['test'],
            ($named->lazy(function() use ($value) {
                $value[] = 'test';
                return $value;
            }))['value']->exec()
        );
    }
}