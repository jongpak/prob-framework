<?php

namespace App\Bootstrap\Test;

use App\Bootstrap\DispatcherBootstrap;
use PHPUnit\Framework\TestCase;

class DispatcherBootstrapTest extends TestCase
{
    private $env;

    public function __construct()
    {
        $this->env = [
            'site' => [
                'url' => '/'
            ],
            'router' => [
                'namespace' => '',
                '/' => function()  {
                    echo 'test!!';
                }
            ],
            'viewEngine' => [],
            'viewResolver' => [
                'App\ViewResolver\DummyResolver'
            ],
            'viewPrefix' => [
                'applyView' => []
            ]
        ];
    }

    public function testDispatch()
    {
        $bootstrap = new DispatcherBootstrap();

        $this->expectOutputString('test!!');
        $bootstrap->boot($this->env);
    }
}