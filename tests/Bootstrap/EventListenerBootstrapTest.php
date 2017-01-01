<?php

namespace App\Bootstrap\Test;

use PHPUnit\Framework\TestCase;
use Core\Bootstrap\Bootstrap;
use Core\Event\EventManager;
use Prob\Handler\ParameterMap;

class EventListenerBootstrapTest extends TestCase
{

    public function testBoot()
    {
        $bootstrap = new Bootstrap([
            'App\\Bootstrap\\EventListenerBootstrap',
        ]);
        $bootstrap->boot([
            'event' => [
                'test' => function () {
                    echo 'foo';
                }
            ]
        ]);

        $this->expectOutputString('foo');
        EventManager::trigger('test', [new ParameterMap()]);
    }
}
