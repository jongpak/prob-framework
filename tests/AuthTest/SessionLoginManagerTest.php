<?php

namespace App\Auth;

use PHPUnit\Framework\TestCase;
use App\Auth\LoginManager\SessionLoginManager;
use App\Auth\AuthManager;
use App\Auth\Exception\AccountNotFound;

class SessionLoginManagerTest extends TestCase
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
                        'accounts' => [
                            'admin' => [
                                'password' => 'admin',
                                'role' => [ 'Admin' ]
                            ],

                            'test' => [
                                'password' => 'test',
                                'role' => [ 'Member' ]
                            ]
                        ]
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

    /**
     * @runInSeparateProcess
     */
    public function testLogin()
    {
        AuthManager::getLoginManager()->login('admin', 'admin');

        $this->assertEquals(true, AuthManager::getLoginManager()->isLogged());
        $this->assertEquals('admin', AuthManager::getLoginManager()->getLoggedAccountId());
    }

    /**
     * @runInSeparateProcess
     */
    public function testLoginFail()
    {
        $this->expectException(AccountNotFound::class);

        AuthManager::getLoginManager()->login('admin', '???');
    }

    /**
     * @runInSeparateProcess
     */
    public function testLogout()
    {
        AuthManager::getLoginManager()->login('admin', 'admin');
        AuthManager::getLoginManager()->logout();

        $this->assertEquals(false, AuthManager::getLoginManager()->isLogged());
        $this->assertEquals(null, AuthManager::getLoginManager()->getLoggedAccountId());
    }
}
