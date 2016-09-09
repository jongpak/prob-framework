<?php

namespace App\Bootstrap;

use Core\Bootstrap\BootstrapInterface;
use Core\EventListenerRegister;
use Core\Application;

class EventListenerBootstrap implements BootstrapInterface
{

    public function boot(Application $app)
    {
        $register = new EventListenerRegister();
        $register->setEventListener($this->getListeners());
        $register->register();
    }

    private function getListeners()
    {
        return require __DIR__ . '/../../config/event.php';
    }
}
