<?php

namespace Core\Bootstrap;

use PHPUnit\Framework\TestCase;

class BootstrapTest extends TestCase
{
    public function testBoot()
    {
        require 'mock/BootTest1.php';
        require 'mock/BootTest2.php';
        require 'mock/BootTest3.php';

        $this->expectOutputString('test1test2test3');

        $bootstrap = new Bootstrap([
            'App\\Bootstrap\\BootTest1',
            'App\\Bootstrap\\BootTest2',
            'App\\Bootstrap\\BootTest3',
        ]);

        $bootstrap->boot();
    }
}
