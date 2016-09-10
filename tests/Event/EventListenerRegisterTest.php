<?php

namespace Core\Event;

use PHPUnit\Framework\TestCase;
use Prob\Handler\ParameterMap;
use Prob\Handler\Parameter\Named;

class EventListenerRegisterTest extends TestCase
{
    public function testRegisterEventListener()
    {
        $listeners = [
            'event.one' => function ($str1) {
                echo $str1;
            },
            'event.two' => function ($str2) {
                echo $str2;
            },
        ];

        $register = new EventListenerRegister();
        $register->setEventListener($listeners);
        $register->register();

        $param = new ParameterMap();
        $param->bindBy(new Named('str1'), 'test1');
        $param->bindBy(new Named('str2'), 'test2');

        $this->expectOutputString('test1test2');
        EventManager::getEventManager()->trigger('event.one', [$param]);
        EventManager::getEventManager()->trigger('event.two', [$param]);
    }
}
