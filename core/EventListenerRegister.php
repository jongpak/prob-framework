<?php

namespace Core;

use Prob\Handler\Proc;
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
            Application::getInstance()
                ->getEventManager()
                    ->on(
                        $eventName,
                        function () use ($handler) {
                            $proc = new Proc($handler, null);
                            $proc->exec();
                        }
                    );
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
}
