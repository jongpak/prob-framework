<?php

namespace App\Auth;

use PHPUnit\Framework\TestCase;
use App\Auth\AccountManager\FileBaseAccountManager;
use App\Auth\LoginManager\SessionLoginManager;
use App\Auth\PermissionManager\FileBasePermissionManager;

class AuthManagerTest extends TestCase
{
    public function setUp()
    {
        AuthManager::setConfig([
            'defaultAllow' => true,
            'defaultAccountManager' => 'FileBaseAccountManager',
            'defaultLoginManager' => 'SessionLoginManager',
            'defaultPermissionManager' => 'FileBasePermissionManager',

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
            ],

            'permissionManagers' => [
                'FileBasePermissionManager' => [
                    'class' => 'App\\Auth\\PermissionManager\\FileBasePermissionManager',
                    'settings' => [
                        'permissions' => []
                    ]
                ]
            ],
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

    public function testGetDefaultPermissionManager()
    {
        $this->assertEquals(FileBasePermissionManager::class, get_class(AuthManager::getPermissionManager()));
    }
}
