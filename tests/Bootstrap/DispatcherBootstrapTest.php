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
        require_once __DIR__ . '/mock/ControllerSample1.php';

        $this->env = [
            'site' => [
                'url' => '/'
            ],
            'router' => [
                'namespace' => 'App\Bootstrap\Test\Mock',
                '/' => 'ControllerSample1.index',
                '/hello' => 'ControllerSample1.hello',
                '/viewPrefix' => 'ControllerSample1.viewPrefix',
            ],
            'viewEngine' => [
                'Twig' => [
                    'path' => __DIR__ . '/../ViewEngineTest/mock/',
                    'postfix' => '.twig',
                    'settings' => []
                ]
            ],
            'viewResolver' => [
                'App\ViewResolver\DummyResolver',
                'Twig' => 'App\ViewResolver\TwigResolver'
            ],
            'viewPrefix' => [
                'applyView' => [
                    'App\ViewEngine\TwigView'
                ],
                'default' => '',
                'controller' => [
                    'ControllerSample1.viewPrefix' => 'prefix/'
                ]
            ]
        ];
    }

    public function testDispatch1()
    {
        $this->env['dispatcher'] = [
            'request' => new ServerRequest([], [], '/', 'GET')
        ];

        $bootstrap = new DispatcherBootstrap();

        $this->expectOutputString('index');
        $bootstrap->boot($this->env);
    }

    public function testDispatch2()
    {
        $this->env['dispatcher'] = [
            'request' => new ServerRequest([], [], '/hello', 'GET')
        ];

        $bootstrap = new DispatcherBootstrap();

        $this->expectOutputString('hello!');
        $bootstrap->boot($this->env);
    }

    public function testViewPrefix()
    {
        $this->env['dispatcher'] = [
            'request' => new ServerRequest([], [], '/viewPrefix', 'GET')
        ];

        $bootstrap = new DispatcherBootstrap();

        $this->expectOutputString('test with prefix!');
        $bootstrap->boot($this->env);
    }
}