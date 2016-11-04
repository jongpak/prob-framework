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
        ];

        $this->assertEquals('test', ArrayUtils::find($arr, 'test'));
        $this->assertEquals('test.*', ArrayUtils::find($arr, 'test.some'));
        $this->assertEquals('test.*.*', ArrayUtils::find($arr, 'test.some.other'));
    }
}
