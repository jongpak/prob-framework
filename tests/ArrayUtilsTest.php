<?php

namespace Core\Utils;

use PHPUnit\Framework\TestCase;

class ArrayUtilsTest extends TestCase
{
    public function testFind()
    {
        $arr = [
            'test.*.*',
            'test.*',
            'test',
            'test\\one.*',
            'test\\two.*'
        ];

        $this->assertEquals('test', ArrayUtils::find($arr, 'test'));
        $this->assertEquals('test.*', ArrayUtils::find($arr, 'test.some'));
        $this->assertEquals('test.*.*', ArrayUtils::find($arr, 'test.some.other'));

        $this->assertEquals('test\\one.*', ArrayUtils::find($arr, 'test\\one.some'));
        $this->assertEquals('test\\two.*', ArrayUtils::find($arr, 'test\\two.other'));
        $this->assertEquals(false, ArrayUtils::find($arr, 'not'));
        $this->assertEquals(false, ArrayUtils::find($arr, 'not.*'));
        $this->assertEquals(false, ArrayUtils::find($arr, '*.not'));
    }
}
