<?php

namespace Core;

use JBZoo\Event\EventManager as ZooEventManager;

class EventManager
{
    private $config = [];

    private function __construct()
    {
    }

    /**
     * @return self
     */
    public static function getInstance()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new self();
        }

        return $instance;
    }

    public function registerListener(array $eventListeners)
    {
        $register = new EventListenerRegister();
        $register->setEventListener($eventListeners);
        $register->register();
    }

    /**
     * @return ZooEventManager
     */
    public function getEventManager()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new ZooEventManager();
        }

        return $instance;
    }
}
