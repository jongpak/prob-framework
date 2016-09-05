<?php

namespace App\Auth;

use PHPUnit\Framework\TestCase;
use App\Auth\AuthManager;
use App\Auth\AccountManager\FileBaseAccountManager;
use App\Auth\LoginManager\SessionLoginManager;

class AuthManagerTest extends TestCase
{

    /**
     * @var AuthManager
     */
    private $authManager;

    public function setUp()
    {
        $authManager = AuthManager::getInstance();

        $authManager->setConfig([
            'defaultAllow' => true,
            'defaultAccountManager' => 'FileBaseAccountManager',
            'defaultLoginManager' => 'SessionLoginManager'
        ]);

        $authManager->setAccountManagerConfig([
            'FileBaseAccountManager' => [
                'class' => 'App\\Auth\\AccountManager\\FileBaseAccountManager',
                'settings' => [
                    'accounts' => []
                ]
            ]
        ]);
        $authManager->setLoginManagerConfig([
            'SessionLoginManager' => [
                'class' => 'App\\Auth\\LoginManager\\SessionLoginManager',
                'settings' => []
            ]
        ]);

        $this->authManager = $authManager;
    }


    public function testGetInstance()
    {
        $this->assertEquals(AuthManager::class, get_class($this->authManager));
    }

    public function testGetDefaultAccountManager()
    {
        $this->assertEquals(FileBaseAccountManager::class, get_class($this->authManager->getDefaultAccountManager()));
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetDefaultLoginManager()
    {
        $this->assertEquals(SessionLoginManager::class, get_class($this->authManager->getDefaultLoginManager()));
    }
}
