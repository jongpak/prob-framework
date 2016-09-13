<?php

namespace App\Bootstrap;

use Core\Bootstrap\BootstrapInterface;
use App\Auth\AuthManager;

class AuthBootstrap implements BootstrapInterface
{
    public function boot(array $env)
    {
        AuthManager::setConfig($env['auth']);
    }
}
