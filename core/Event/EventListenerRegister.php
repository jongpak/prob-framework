<?php

namespace Core\Event;

use Prob\Handler\ProcFactory;
use Prob\Handler\ParameterMap;
use Prob\Handler\ProcInterface;
use Prob\Handler\Proc\MethodProc;
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
            if (is_array($handler) === false) {
                $handler = [$handler];
            }

            foreach ($handler as $handlerItem) {
                $this->registerHandler($eventName, $handlerItem);
            }
        }
    }

    private function registerHandler($eventName, $handler)
    {
        $proc = $this->getEventListenerProc($handler);
        EventManager::register($eventName, $proc);
    }

    private function getEventNames()
    {
        $glue = new KeyGlue();
        $glue->setArray($this->eventListeners);
        $glue->setGlueCharacter('.');

        return $glue->glueKeyAndContainValue();
    }

    private function getEventListenerProc($handler)
    {
        return function (ParameterMap $parameterMap) use ($handler) {
            /** @var ProcInterface */
            $proc = ProcFactory::getProc($handler);
            if ($proc instanceof MethodProc) {
                $proc->execConstructorWithParameterMap($parameterMap);
            }
            $proc->execWithParameterMap($parameterMap);
        };
    }
}
