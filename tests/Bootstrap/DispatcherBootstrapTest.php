<?php

namespace App\Bootstrap\Test;

use App\Bootstrap\DispatcherBootstrap;
use PHPUnit\Framework\TestCase;
use Prob\Router\Map;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Uri;

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