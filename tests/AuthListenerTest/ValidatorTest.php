<?php

namespace App\EventListener\Auth;

use PHPUnit\Framework\TestCase;
use App\Auth\AuthManager;
use App\EventListener\Auth\Test\Mock\TestAdminProc;
use App\EventListener\Auth\Exception\PermissionDenied;

class ValidatorTest extends TestCase
{
    /**
     * @var AuthManager
     */
    private $authManager;

    /**
     * @runInSeparateProcess
     */
    public function setUp()
    {
        include_once 'mock/TestAdminProc.php';

        AuthManager::setConfig($this->getAuthConfig());
    }

    private function getAuthConfig($defaultAllow = true, array $permission = [])
    {
        return [
            'defaultAllow' => $defaultAllow,
            'defaultAccountManager' => 'FileBaseAccountManager',
            'defaultLoginManager' => 'SessionLoginManager',
            'defaultPermissionManager' => 'FileBasePermissionManager',

            'accountManagers' => [
                'FileBaseAccountManager' => [
                    'class' => 'App\\Auth\\AccountManager\\FileBaseAccountManager',
                    'settings' => [
                        'accounts' => [
                            'admin' => [
                                'password' => 'admin',
                                'role' => ['Admin']
                            ],
                            'test' => [
                                'password' => 'test',
                                'role' => ['Member']
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
            ],

            'permissionManagers' => [
                'FileBasePermissionManager' => [
                    'class' => 'App\\Auth\\PermissionManager\\FileBasePermissionManager',
                    'settings' => [
                        'permissions' => $permission
                    ]
                ]
            ],
        ];
    }

    /**
     * @runInSeparateProcess
     */
    public function testValidator1()
    {
        AuthManager::getLoginManager()->logout();
        AuthManager::setConfig($this->getAuthConfig(true, [
            'Test.admin' => ['Admin']
        ]));

        $this->expectException(PermissionDenied::class);
        (new ValidatorListener())->validate(new TestAdminProc(null), AuthManager::getLoginManager());
    }

    /**
     * @runInSeparateProcess
     */
    public function testValidator2()
    {
        AuthManager::getLoginManager()->login('admin', 'admin');
        AuthManager::setConfig($this->getAuthConfig(true, [
            'Test.admin' => ['Admin']
        ]));

        $this->assertEquals(true, (new ValidatorListener())->validate(new TestAdminProc(null), AuthManager::getLoginManager()));
    }

    /**
     * @runInSeparateProcess
     */
    public function testValidator3()
    {
        AuthManager::getLoginManager()->login('test', 'test');
        AuthManager::setConfig($this->getAuthConfig(true, [
            'Test.admin' => ['Admin']
        ]));

        $this->expectException(PermissionDenied::class);
        (new ValidatorListener())->validate(new TestAdminProc(null), AuthManager::getLoginManager());
    }

    /**
     * @runInSeparateProcess
     */
    public function testValidator4()
    {
        AuthManager::getLoginManager()->login('test', 'test');
        AuthManager::setConfig($this->getAuthConfig(true, [
            'Test.admin' => ['Admin', 'Member']
        ]));

        $this->assertEquals(true, (new ValidatorListener())->validate(new TestAdminProc(null), AuthManager::getLoginManager()));
    }

    /**
     * @runInSeparateProcess
     */
    public function testValidator5()
    {
        AuthManager::getLoginManager()->login('test', 'test');
        AuthManager::setConfig($this->getAuthConfig(true, [
            'Test.admin' => []
        ]));

        $this->expectException(PermissionDenied::class);
        (new ValidatorListener())->validate(new TestAdminProc(null), AuthManager::getLoginManager());
    }

    /**
     * @runInSeparateProcess
     */
    public function testValidator6()
    {
        AuthManager::getLoginManager()->login('test', 'test');
        AuthManager::setConfig($this->getAuthConfig(true, [
            'Test.admin' => []
        ]));

        $this->expectException(PermissionDenied::class);
        $this->assertEquals(true, (new ValidatorListener())->validate(new TestAdminProc(null), AuthManager::getLoginManager()));
    }

    /**
     * @runInSeparateProcess
     */
    public function testValidatorDefaultAllowTrue()
    {
        AuthManager::getLoginManager()->login('test', 'test');
        AuthManager::setConfig($this->getAuthConfig(true, []));

        $this->assertEquals(true, (new ValidatorListener())->validate(new TestAdminProc(null), AuthManager::getLoginManager()));
    }

    /**
     * @runInSeparateProcess
     */
    public function testValidatorDefaultAllowFalse()
    {
        AuthManager::getLoginManager()->login('test', 'test');
        AuthManager::setConfig($this->getAuthConfig(false, []));

        $this->expectException(PermissionDenied::class);
        (new ValidatorListener())->validate(new TestAdminProc(null), AuthManager::getLoginManager());
    }
}
