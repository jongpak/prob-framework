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

    public static function register($eventName, callable $handler, $priority = null) {
        self::getEventManager()->on($eventName, $handler, $priority);
    }

    public static function trigger($eventName, array $arguments = [], callable $callback = null)
    {
        return self::getEventManager()->trigger($eventName, $arguments, $callback);
    }

    /**
     * @return ZooEventManager
     */
    private static function getEventManager()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new ZooEventManager();
        }

        return $instance;
    }
}
