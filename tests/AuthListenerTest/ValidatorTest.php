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
            ]
        ]);
    }

    /**
     * @runInSeparateProcess
     */
    public function testValidator1()
    {
        AuthManager::getLoginManager()->logout();

        $validator = new Validator([
            'Test.admin' => [
                'role' => ['Admin']
            ]
        ]);

        $this->expectException(PermissionDenied::class);

        $validator->validate(new TestAdminProc(null));
    }

    /**
     * @runInSeparateProcess
     */
    public function testValidator2()
    {
        AuthManager::getLoginManager()->login('admin', 'admin');

        $validator = new Validator([
            'Test.admin' => [
                'role' => ['Admin']
            ]
        ]);

        $this->assertEquals(true, $validator->validate(new TestAdminProc(null)));
    }

    /**
     * @runInSeparateProcess
     */
    public function testValidator3()
    {
        AuthManager::getLoginManager()->login('test', 'test');

        $validator = new Validator([
            'Test.admin' => [
                'role' => ['Admin']
            ]
        ]);

        $this->expectException(PermissionDenied::class);
        $validator->validate(new TestAdminProc(null));
    }

    /**
     * @runInSeparateProcess
     */
    public function testValidator4()
    {
        AuthManager::getLoginManager()->login('test', 'test');

        $validator = new Validator([
            'Test.admin' => [
                'role' => ['Admin', 'Member']
            ]
        ]);

        $this->assertEquals(true, $validator->validate(new TestAdminProc(null)));
    }

    /**
     * @runInSeparateProcess
     */
    public function testValidator5()
    {
        AuthManager::getLoginManager()->login('test', 'test');

        $validator = new Validator([
            'Test.admin' => [
                'role' => []
            ]
        ]);

        $this->expectException(PermissionDenied::class);
        $this->assertEquals(true, $validator->validate(new TestAdminProc(null)));
    }

    /**
     * @runInSeparateProcess
     */
    public function testValidator6()
    {
        AuthManager::getLoginManager()->login('test', 'test');

        $validator = new Validator([
            'Test.admin' => [
            ]
        ]);

        $this->expectException(PermissionDenied::class);
        $this->assertEquals(true, $validator->validate(new TestAdminProc(null)));
    }

    /**
     * @runInSeparateProcess
     */
    public function testValidatorDefaultAllowTrue()
    {
        AuthManager::getLoginManager()->login('test', 'test');

        AuthManager::setConfig([
            'defaultAllow' => true,
            'defaultAccountManager' => 'FileBaseAccountManager',
            'defaultLoginManager' => 'SessionLoginManager'
        ]);
        $validator = new Validator([]);

        $this->assertEquals(true, $validator->validate(new TestAdminProc(null)));
    }

    /**
     * @runInSeparateProcess
     */
    public function testValidatorDefaultAllowFalse()
    {
        AuthManager::getLoginManager()->login('test', 'test');

        AuthManager::setConfig([
            'defaultAllow' => false,
            'defaultAccountManager' => 'FileBaseAccountManager',
            'defaultLoginManager' => 'SessionLoginManager'
        ]);
        $validator = new Validator([]);

        $this->expectException(PermissionDenied::class);
        $validator->validate(new TestAdminProc(null));
    }
}
