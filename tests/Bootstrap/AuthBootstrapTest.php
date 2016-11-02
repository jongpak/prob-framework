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
                'defaultLoginManager' => 'DummyLoginManager',

                'accountManagers' => [
                    'DummyAccountManager' => [
                        'class' => 'App\\Auth\\AccountManager\\Test\\DummyAccountManager',
                        'settings' => []
                    ]
                ],

                'loginManagers' => [
                    'DummyLoginManager' => [
                        'class' => 'App\\Auth\\LoginManager\\Test\\DummyLoginManager',
                        'settings' => []
                    ]
                ]
            ],

            'hashProvider' => [
                'defaultHashProvider' => 'BCryptHashProvider',

                'hashProviders' => [
                    'BCryptHashProvider' => [
                        'class' => 'App\\Auth\\HashProvider\\BCryptHashProvider',
                        'settings' => []
                    ]
                ]
            ]
        ]);

        $this->assertEquals(true, AuthManager::isDefaultAllow());
        $this->assertEquals(DummyAccountManager::class, get_class(AuthManager::getAccountManager()));
        $this->assertEquals(DummyLoginManager::class, get_class(AuthManager::getLoginManager()));
    }
}
