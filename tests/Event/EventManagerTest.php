<?php

namespace Core\Event;

use PHPUnit\Framework\TestCase;
use Prob\Handler\ParameterMap;
use JBZoo\Event\EventManager as ZooEventManager;

class EventManagerTest extends TestCase
{
    public function testGetEventManager()
    {
        $this->assertEquals(ZooEventManager::class, get_class(EventManager::getEventManager()));
    }

    public function testRegisterListener()
    {
        EventManager::registerListener([
            'test.event' => function () {
                echo 'test!';
            }
        ]);

        $this->expectOutputString('test!');
        EventManager::getEventManager()->trigger('test.event', [new ParameterMap]);
    }
}
