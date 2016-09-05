<?php

namespace App\Auth;

use PHPUnit\Framework\TestCase;
use App\Auth\LoginManager\SessionLoginManager;
use App\Auth\AuthManager;
use App\Auth\Exception\AccountNotFound;

class SessionLoginManagerTest extends TestCase
{

    /**
     * @var SessionLoginManager
     */
    private $loginManager;

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
        ]);
        $authManager->setLoginManagerConfig([
            'SessionLoginManager' => [
                'class' => 'App\\Auth\\LoginManager\\SessionLoginManager',
                'settings' => []
            ]
        ]);

        $this->loginManager = new SessionLoginManager();
    }

    /**
     * @runInSeparateProcess
     */
    public function testLogin()
    {
        $this->loginManager->login('admin', 'admin');

        $this->assertEquals(true, $this->loginManager->isLogged());
        $this->assertEquals('admin', $this->loginManager->getLoggedAccountId());
    }

    /**
     * @runInSeparateProcess
     */
    public function testLoginFail()
    {
        $this->expectException(AccountNotFound::class);

        $this->loginManager->login('admin', '???');
    }

    /**
     * @runInSeparateProcess
     */
    public function testLogout()
    {
        $this->loginManager->login('admin', 'admin');
        $this->loginManager->logout();

        $this->assertEquals(false, $this->loginManager->isLogged());
        $this->assertEquals(null, $this->loginManager->getLoggedAccountId());
    }
}
