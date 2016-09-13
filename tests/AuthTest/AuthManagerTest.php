<?php

namespace App\Auth;

use PHPUnit\Framework\TestCase;
use App\Auth\AuthManager;
use App\Auth\AccountManager\FileBaseAccountManager;
use App\Auth\LoginManager\SessionLoginManager;

class AuthManagerTest extends TestCase
{
    public function setUp()
    {
        AuthManager::setConfig([
            'defaultAllow' => true,
            'defaultAccountManager' => 'FileBaseAccountManager',
            'defaultLoginManager' => 'SessionLoginManager',

            'accountManagers' => [
                'FileBaseAccountManager' => [
                    'class' => 'App\\Auth\\AccountManager\\FileBaseAccountManager',
                    'settings' => [
                        'accounts' => []
                    ]
                ]
            ],

            'loginManagers' => [
                'SessionLoginManager' => [
                    'class' => 'App\\Auth\\LoginManager\\SessionLoginManager',
                    'settings' => []
                ]
            ]
        ]);
    }


    public function testGetDefaultAccountManager()
    {
        $this->assertEquals(FileBaseAccountManager::class, get_class(AuthManager::getAccountManager()));
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetDefaultLoginManager()
    {
        $this->assertEquals(SessionLoginManager::class, get_class(AuthManager::getLoginManager()));
    }
}
