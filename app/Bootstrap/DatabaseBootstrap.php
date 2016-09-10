<?php

namespace App\Bootstrap;

use Core\Bootstrap\BootstrapInterface;
use Core\DatabaseManager;

class DatabaseBootstrap implements BootstrapInterface
{
    public function boot(array $env)
    {
        DatabaseManager::setDefaultConfig($env['db']);
    }
}
