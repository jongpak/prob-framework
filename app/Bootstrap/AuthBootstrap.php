<?php

namespace App\Bootstrap;

use App\Auth\HashManager;
use Core\Bootstrap\BootstrapInterface;
use App\Auth\AuthManager;

class AuthBootstrap implements BootstrapInterface
{
    public function boot(array $env)
    {
        HashManager::setConfig($env['hashProvider']);
        AuthManager::setConfig($env['auth']);
    }
}
