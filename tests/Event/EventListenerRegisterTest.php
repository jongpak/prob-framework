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
            'event.array' => [
                function () {
                    echo 'hello';
                },
                function () {
                    echo 'world';
                }
            ],
            'event.method' => 'App\\EventListener\\TestEventListener.printText'
        ];

        require_once(__DIR__ . '/../mock/TestEventListener.php');

        $register = new EventListenerRegister();
        $register->setEventListener($listeners);
        $register->register();

        $param = new ParameterMap();
        $param->bindBy(new Named('str1'), 'test1');
        $param->bindBy(new Named('str2'), 'test2');

        $this->expectOutputString('test1/test2/helloworld/construct_test1test2');
        EventManager::trigger('event.one', [$param]);
        echo '/';
        EventManager::trigger('event.two', [$param]);
        echo '/';
        EventManager::trigger('event.array', [$param]);
        echo '/';
        EventManager::trigger('event.method', [$param]);
    }
}
