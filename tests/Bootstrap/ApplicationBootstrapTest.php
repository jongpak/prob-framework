<?php

namespace App\Bootstrap\Test;

use PHPUnit\Framework\TestCase;
use Core\Application;
use Core\Bootstrap\Bootstrap;

class ApplicationBootstrapTeest extends TestCase
{

    public function testBoot()
    {
        $bootstrap = new Bootstrap([
            'App\\Bootstrap\\ApplicationBootstrap',
        ]);
        $bootstrap->boot([
            'site' => [
                'url' => '/test/prob/',
                'publicPath' => '/test/prob/public/',
            ]
        ]);

        $this->assertEquals('/test/prob/', Application::getInstance()->url());
        $this->assertEquals('/test/prob/public/', Application::getInstance()->getPublicUrl());
    }
}
