<?php

namespace App\Bootstrap;

use Core\Bootstrap\BootstrapInterface;
use Core\EventManager;

class EventListenerBootstrap implements BootstrapInterface
{
    public function boot()
    {
        EventManager::registerListener($this->getListeners());
    }

    private function getListeners()
    {
        return require __DIR__ . '/../../config/event.php';
    }
}
