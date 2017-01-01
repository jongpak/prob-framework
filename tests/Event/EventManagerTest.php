<?php

namespace Core\Event;

use PHPUnit\Framework\TestCase;
use Prob\Handler\ParameterMap;

class EventManagerTest extends TestCase
{
    public function testRegisterListener()
    {
        EventManager::registerListener([
            'test.event' => function () {
                echo 'test!';
            }
        ]);

        $this->expectOutputString('test!');
        EventManager::trigger('test.event', [new ParameterMap]);
    }
}
