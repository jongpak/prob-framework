<?php

namespace Core\ControllerDispatcher;

use Core\Event\EventManager;

class ControllerEvent
{
    public static function triggerEvent($controller, $action, array $parameter)
    {
        EventManager::getEventManager()->trigger(self::getEventName($controller, $action), $parameter);
    }

    /**
     * @param  string $action 'before' || 'after'
     * @return string event name
     */
    private static function getEventName($controller, $action)
    {
        return sprintf('Controller.%s.%s', $controller, $action);
    }
}
