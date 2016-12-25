<?php

namespace App\Bootstrap\Test;

use App\Bootstrap\DispatcherBootstrap;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;

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
                    echo 'index';
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
        $this->env['dispatcher'] = [
            'request' => new ServerRequest([], [], '/', 'GET')
        ];

        $bootstrap = new DispatcherBootstrap();

        $this->expectOutputString('index');
        $bootstrap->boot($this->env);
    }
}