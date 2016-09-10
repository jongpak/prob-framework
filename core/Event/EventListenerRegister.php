<?php

namespace Core\Event;

use Prob\Handler\ProcFactory;
use Prob\Handler\ParameterMap;
use Prob\ArrayUtil\KeyGlue;

class EventListenerRegister
{
    private $eventListeners = [];

    public function setEventListener(array $eventListeners)
    {
        $this->eventListeners = $eventListeners;
    }

    public function register()
    {
        foreach ($this->getEventNames() as $eventName => $handler) {
            $proc = $this->getEventListenerProc($handler);
            EventManager::getEventManager()->on($eventName, $proc);
        }
    }

    private function getEventNames()
    {
        $glue = new KeyGlue();
        $glue->setArray($this->eventListeners);
        $glue->setWithValue(true);
        $glue->setGlueCharacter('.');

        return $glue->glue();
    }

    private function getEventListenerProc($handler)
    {
        return function (ParameterMap $parameterMap) use ($handler) {
            /** @var ProcInterface */
            $proc = ProcFactory::getProc($handler);
            $proc->execWithParameterMap($parameterMap);
        };
    }
}
