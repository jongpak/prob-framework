<?php

namespace Core\Utils;

use PHPUnit\Framework\TestCase;

class ArrayUtilsTest extends TestCase
{
    public function testFind1()
    {
        $arr = [
            'test.*.*',
            'test.*',
            'test',
            'test\\one.*',
            'test\\two.*',
            'abc*',
        ];

        $this->assertEquals('test', ArrayUtils::find($arr, 'test'));
        $this->assertEquals('test.*', ArrayUtils::find($arr, 'test.some'));
        $this->assertEquals('test.*.*', ArrayUtils::find($arr, 'test.some.other'));
        $this->assertEquals('abc*', ArrayUtils::find($arr, 'abc123'));

        $this->assertEquals('test\\one.*', ArrayUtils::find($arr, 'test\\one.some'));
        $this->assertEquals('test\\two.*', ArrayUtils::find($arr, 'test\\two.other'));

        $this->assertEquals(false, ArrayUtils::find($arr, 'not'));
        $this->assertEquals(false, ArrayUtils::find($arr, 'not.*'));
        $this->assertEquals(false, ArrayUtils::find($arr, '*.not'));
    }

    public function testFind2()
    {
        $arr = [
            'test',
            'test.some',
            'test.some.other',
            'test\\one.some',
            'test\\two.other',
            'abc123',
        ];

        $this->assertEquals('test', ArrayUtils::find($arr, 'test'));
        $this->assertEquals('test.some', ArrayUtils::find($arr, 'test.*'));
        $this->assertEquals('test.some.other', ArrayUtils::find($arr, 'test.*.*'));
        $this->assertEquals('abc123', ArrayUtils::find($arr, 'abc*'));

        $this->assertEquals('test\\one.some', ArrayUtils::find($arr, 'test\\one.*'));
        $this->assertEquals('test\\two.other', ArrayUtils::find($arr, 'test\\two.*'));

        $this->assertEquals(false, ArrayUtils::find($arr, 'not'));
        $this->assertEquals(false, ArrayUtils::find($arr, 'not.*'));
        $this->assertEquals(false, ArrayUtils::find($arr, '*.not'));
    }
}
