<?php

namespace App\Bootstrap;

use Core\Bootstrap\BootstrapInterface;
use App\Auth\AuthManager;

class AuthBootstrap implements BootstrapInterface
{
    public function boot()
    {
        $auth = AuthManager::getInstance();

        $auth->setConfig($this->getConfig());
        $auth->setAccountManagerConfig($this->getAccountManagerConfig());
        $auth->setLoginManagerConfig($this->getLoginManagerConfig());
    }

    private function getConfig()
    {
        return require __DIR__ . '/../Auth/config/config.php';
    }

    private function getAccountManagerConfig()
    {
        return require __DIR__ . '/../Auth/config/accountManager.php';
    }

    private function getLoginManagerConfig()
    {
        return require __DIR__ . '/../Auth/config/loginManager.php';
    }
}
