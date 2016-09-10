<?php

namespace App\Bootstrap\Test;

use PHPUnit\Framework\TestCase;
use Core\Bootstrap\Bootstrap;
use App\Auth\AuthManager;
use App\Auth\AccountManager\Test\DummyAccountManager;
use App\Auth\LoginManager\Test\DummyLoginManager;

class AuthBootstrapTest extends TestCase
{

    public function testBoot()
    {
        require 'mock/DummyAccountManager.php';
        require 'mock/DummyLoginManager.php';

        $bootstrap = new Bootstrap([
            'App\\Bootstrap\\AuthBootstrap',
        ]);
        $bootstrap->boot([
            'auth' => [
                'defaultAllow' => true,
                'defaultAccountManager' => 'DummyAccountManager',
                'defaultLoginManager' => 'DummyLoginManager'
            ],
            'accountManager' => [
                'DummyAccountManager' => [
                    'class' => 'App\\Auth\\AccountManager\\Test\\DummyAccountManager',
                    'settings' => []
                ]
            ],
            'loginManager' => [
                'DummyLoginManager' => [
                    'class' => 'App\\Auth\\LoginManager\\Test\\DummyLoginManager',
                    'settings' => []
                ]
            ],
        ]);

        $authManager = AuthManager::getInstance();

        $this->assertEquals(true, $authManager->isDefaultAllow());
        $this->assertEquals(DummyAccountManager::class, get_class($authManager->getDefaultAccountManager()));
        $this->assertEquals(DummyLoginManager::class, get_class($authManager->getDefaultLoginManager()));
    }
}
