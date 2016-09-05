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
                            'role' => ['Admin']
                        ],
                        'test' => [
                            'password' => 'test',
                            'role' => ['Member']
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

        $this->authManager = $authManager;
    }

    /**
     * @runInSeparateProcess
     */
    public function testValidator1()
    {
        $this->authManager->getDefaultLoginManager()->logout();

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
        $this->authManager->getDefaultLoginManager()->login('admin', 'admin');

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
        $this->authManager->getDefaultLoginManager()->login('test', 'test');

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
        $this->authManager->getDefaultLoginManager()->login('test', 'test');

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
        $this->authManager->getDefaultLoginManager()->login('test', 'test');

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
        $this->authManager->getDefaultLoginManager()->login('test', 'test');

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
        $this->authManager->getDefaultLoginManager()->login('test', 'test');

        $this->authManager->setConfig([
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
        $this->authManager->getDefaultLoginManager()->login('test', 'test');

        $this->authManager->setConfig([
            'defaultAllow' => false,
            'defaultAccountManager' => 'FileBaseAccountManager',
            'defaultLoginManager' => 'SessionLoginManager'
        ]);
        $validator = new Validator([]);

        $this->expectException(PermissionDenied::class);
        $validator->validate(new TestAdminProc(null));
    }
}
