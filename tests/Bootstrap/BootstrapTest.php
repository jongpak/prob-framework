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

        $this->expectOutputString('env1env2env3');

        $bootstrap = new Bootstrap([
            'App\\Bootstrap\\BootTest1',
            'App\\Bootstrap\\BootTest2',
            'App\\Bootstrap\\BootTest3',
        ]);
        $bootstrap->boot([
            'test1' => 'env1',
            'test2' => 'env2',
            'test3' => 'env3',
        ]);
    }
}
