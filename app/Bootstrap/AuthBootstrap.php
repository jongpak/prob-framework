<?php

namespace App\Bootstrap;

use Core\Bootstrap\BootstrapInterface;
use App\Auth\AuthManager;

class AuthBootstrap implements BootstrapInterface
{
    public function boot(array $env)
    {
        $auth = AuthManager::getInstance();
        $auth->setConfig($env['auth']);
        $auth->setAccountManagerConfig($env['accountManager']);
        $auth->setLoginManagerConfig($env['loginManager']);
    }
}
