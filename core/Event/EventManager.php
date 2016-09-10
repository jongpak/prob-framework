<?php

namespace Core\Event;

use JBZoo\Event\EventManager as ZooEventManager;

class EventManager
{
    public static function registerListener(array $eventListeners)
    {
        $register = new EventListenerRegister();
        $register->setEventListener($eventListeners);
        $register->register();
    }

    /**
     * @return ZooEventManager
     */
    public static function getEventManager()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new ZooEventManager();
        }

        return $instance;
    }
}
