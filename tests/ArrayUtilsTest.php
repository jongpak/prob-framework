<?php

namespace Core\Utils;

use InvalidArgumentException;
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
            'test\\three.*',
            'abc*',
            'test*abc',
        ];

        $this->assertEquals('test', ArrayUtils::find($arr, 'test'));
        $this->assertEquals('test.*', ArrayUtils::find($arr, 'test.some'));
        $this->assertEquals('test.*.*', ArrayUtils::find($arr, 'test.some.other'));
        $this->assertEquals('abc*', ArrayUtils::find($arr, 'abc123'));
        $this->assertEquals('test*abc', ArrayUtils::find($arr, 'test123abc'));

        $this->assertEquals('test\\one.*', ArrayUtils::find($arr, 'test\\one.some'));
        $this->assertEquals('test\\two.*', ArrayUtils::find($arr, 'test\\two.other'));

        $this->assertEquals(false, ArrayUtils::find($arr, 'not'));
        $this->assertEquals(false, ArrayUtils::find($arr, 'not.*'));
        $this->assertEquals(false, ArrayUtils::find($arr, '*.not'));

        $this->assertEquals(false, ArrayUtils::find($arr, 'test123'));
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
            'test123abc',
        ];

        $this->assertEquals('test', ArrayUtils::find($arr, 'test'));
        $this->assertEquals('test.some', ArrayUtils::find($arr, 'test.*'));
        $this->assertEquals('test.some.other', ArrayUtils::find($arr, 'test.*.*'));
        $this->assertEquals('abc123', ArrayUtils::find($arr, 'abc*'));
        $this->assertEquals('test123abc', ArrayUtils::find($arr, 'test*abc'));

        $this->assertEquals('test\\one.some', ArrayUtils::find($arr, 'test\\one.*'));
        $this->assertEquals('test\\two.other', ArrayUtils::find($arr, 'test\\two.*'));

        $this->assertEquals(false, ArrayUtils::find($arr, 'not'));
        $this->assertEquals(false, ArrayUtils::find($arr, 'not.*'));
        $this->assertEquals(false, ArrayUtils::find($arr, '*.not'));
    }

    public function testValueArray1()
    {
        $arr = [
            'test.1' => [ 'test' ]
        ];

        $this->assertEquals('test.1', ArrayUtils::find($arr, 'test.*'));
    }

    public function testValueArray2()
    {
        $arr = [
            'test.*' => [ 'test' ]
        ];

        $this->assertEquals('test.*', ArrayUtils::find($arr, 'test.1'));
    }

    public function testNotStringKey1()
    {
        $this->expectException(InvalidArgumentException::class);
        ArrayUtils::find([ [ ] ], 'some');
    }

    public function testNotStringKey2()
    {
        $this->expectException(InvalidArgumentException::class);
        ArrayUtils::find([ true ], 'some');
    }

    public function testNotStringKey3()
    {
        $this->expectException(InvalidArgumentException::class);
        ArrayUtils::find([ 5 ], 'some');
    }

    public function testNotStringKey4()
    {
        $this->expectException(InvalidArgumentException::class);
        ArrayUtils::find([ new \stdClass() ], 'some');
    }

    public function testEmpty()
    {
        $this->assertEquals(false, ArrayUtils::find([], ''));
        $this->assertEquals(false, ArrayUtils::find([], 'test'));
    }
}
