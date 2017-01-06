<?php

namespace App\Auth;

use PHPUnit\Framework\TestCase;
use App\Auth\AccountManager\FileBaseAccountManager;

class FileBaseAccountManagerTest extends TestCase
{
    /**
     * @var FileBaseAccountManager
     */
    private $accountManager;

    public function setUp()
    {
        $this->accountManager = new FileBaseAccountManager([
            'accounts' => [
                'admin' => [
                    'name' => 'Admin',
                    'password' => 'admin',
                    'role' => [ 'Admin' ]
                ],

                'test' => [
                    'name' => 'Tester1',
                    'password' => 'test',
                    'role' => [ 'Member' ]
                ],

                'test2' => [
                    'name' => 'Tester2',
                    'password' => 'test',
                    'role' => [ 'Admin', 'Member' ]
                ]
            ]
        ]);
    }

    public function testIsExistAccountId()
    {
        $this->assertEquals(true, $this->accountManager->isExistAccountId('admin'));
        $this->assertEquals(true, $this->accountManager->isExistAccountId('test'));
        $this->assertEquals(false, $this->accountManager->isExistAccountId('noAccount'));
    }

    public function testIsEqualPassword()
    {
        $this->assertEquals(true, $this->accountManager->isEqualPassword('admin', 'admin'));
        $this->assertEquals(false, $this->accountManager->isEqualPassword('admin', '???'));

        $this->assertEquals(true, $this->accountManager->isEqualPassword('test', 'test'));
        $this->assertEquals(false, $this->accountManager->isEqualPassword('test', '???'));

        $this->assertEquals(false, $this->accountManager->isEqualPassword('noAccount', '???'));
    }

    public function testGetAccountById()
    {
        $this->assertEquals(null, $this->accountManager->getAccountById('nonAccountID'));

        $this->assertEquals('admin', $this->accountManager->getAccountById('admin')->getAccountId());
        $this->assertEquals('admin', $this->accountManager->getAccountById('admin')->getPassword());
        $this->assertEquals('Admin', $this->accountManager->getAccountById('admin')->getName());
    }

    public function testGetRole()
    {
        $this->assertEquals(['Admin'], $this->accountManager->getRole('admin'));
        $this->assertEquals(['Member'], $this->accountManager->getRole('test'));
        $this->assertEquals(['Admin', 'Member'], $this->accountManager->getRole('test2'));
        $this->assertEquals(null, $this->accountManager->getRole('noAccount'));
    }
}
