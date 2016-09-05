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
        $this->accountManeger = new FileBaseAccountManager([
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
        ]);
    }

    public function testIsExistAccountId()
    {
        $this->assertEquals(true, $this->accountManeger->isExistAccountId('admin'));
        $this->assertEquals(true, $this->accountManeger->isExistAccountId('test'));
        $this->assertEquals(false, $this->accountManeger->isExistAccountId('noAccount'));
    }

    public function testIsEqualPassword()
    {
        $this->assertEquals(true, $this->accountManeger->isEqualPassword('admin', 'admin'));
        $this->assertEquals(false, $this->accountManeger->isEqualPassword('admin', '???'));

        $this->assertEquals(true, $this->accountManeger->isEqualPassword('test', 'test'));
        $this->assertEquals(false, $this->accountManeger->isEqualPassword('test', '???'));

        $this->assertEquals(false, $this->accountManeger->isEqualPassword('noAccount', '???'));
    }

    public function testGetRole()
    {
        $this->assertEquals(['Admin'], $this->accountManeger->getRole('admin'));
        $this->assertEquals(['Member'], $this->accountManeger->getRole('test'));
        $this->assertEquals(null, $this->accountManeger->getRole('noAccount'));
    }
}
