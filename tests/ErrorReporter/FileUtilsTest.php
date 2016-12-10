<?php

namespace Core\ErrorReporter;

use PHPUnit\Framework\TestCase;

class FileUtilsTest extends TestCase
{
    private $zeroLineFile = __DIR__ . '/' . 'zeroLineTest.txt';
    private $moreLineFile = __DIR__ . '/' . 'moreLineTest.txt';

    public function testGetLinesOfZeroLine()
    {
        $lines = FileUtils::getLines($this->zeroLineFile, 0, 1);

        $this->assertEquals(1, count($lines));
        $this->assertEquals('', $lines[0]);
    }

    public function testGetLinesOfMultiLine()
    {
        $lines = FileUtils::getLines($this->moreLineFile, 0, 3);

        $this->assertEquals(3, count($lines));
        $this->assertEquals('0', $lines[0]);
        $this->assertEquals('1', $lines[1]);
        $this->assertEquals('2', $lines[2]);

        $lines = FileUtils::getLines($this->moreLineFile, 5, 3);

        $this->assertEquals(3, count($lines));
        $this->assertEquals('5', $lines[5]);
        $this->assertEquals('6', $lines[6]);
        $this->assertEquals('7', $lines[7]);
    }

    public function testGetLinesOfMOverflowLine()
    {
        $lines = FileUtils::getLines($this->moreLineFile, 20, 5);
        $this->assertEquals(0, count($lines));

        $lines = FileUtils::getLines($this->moreLineFile, 15, 5);
        $this->assertEquals(0, count($lines));

        $lines = FileUtils::getLines($this->moreLineFile, 14, 5);
        $this->assertEquals(1, count($lines));
        $this->assertEquals('14', $lines[14]);
    }

    public function testGetLinesOfUnderflowLine()
    {
        $lines = FileUtils::getLines($this->moreLineFile, -100, 3);
        $this->assertEquals(3, count($lines));
        $this->assertEquals('0', $lines[0]);
        $this->assertEquals('1', $lines[1]);
        $this->assertEquals('2', $lines[2]);

        $lines = FileUtils::getLines($this->moreLineFile, 5, -3);
        $this->assertEquals(0, count($lines));
    }
}
