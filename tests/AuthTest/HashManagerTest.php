<?php

namespace App\Auth;

use App\Auth\HashProvider\BCryptHashProvider;
use PHPUnit\Framework\TestCase;

class HashManagerTest extends TestCase
{
    public function setUp()
    {
        HashManager::setProvider([
            'BCryptHashProvider' => [
                'class' => 'App\\Auth\\HashProvider\\BCryptHashProvider',
                'settings' => []
            ]
        ]);
        HashManager::setDefaultProviderName('BCryptHashProvider');
    }

    public function testGetProvider() {
        $this->assertEquals(BCryptHashProvider::class, get_class(HashManager::getProvider('BCryptHashProvider')));
    }

    public function testGetDefaultProvider()
    {
        $this->assertEquals(BCryptHashProvider::class, get_class(HashManager::getProvider()));
    }
}