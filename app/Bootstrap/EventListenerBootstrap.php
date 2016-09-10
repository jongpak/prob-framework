<?php

namespace App\Bootstrap;

use Core\Bootstrap\BootstrapInterface;
use Core\Event\EventManager;

class EventListenerBootstrap implements BootstrapInterface
{
    public function boot(array $env)
    {
        EventManager::registerListener($env['event']);
    }
}
