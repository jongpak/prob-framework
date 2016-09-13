<?php

namespace Core;

use PHPUnit\Framework\TestCase;
use Core\MockDatabaseManager;
use Doctrine\ORM\EntityManager;

class DatabaseManagerTest extends TestCase
{
    public function setUp()
    {
        require_once 'mock/MockDatabaseManager.php';
    }

    public function testGetDefaultEntityManager()
    {
        MockDatabaseManager::setConfig([
            'defaultConnection' => 'test',
            'entityPath'        => [ null ],
            'devMode'           => true,
            'connections' => [
                'test' => [
                    'driver'    => 'pdo_mysql',
                ]
            ]
        ]);

        $this->assertEquals(EntityManager::class, get_class(MockDatabaseManager::getEntityManager()));
    }

    public function testGetUserEntityManager()
    {
        $dbManager = new MockDatabaseManager;
        $dbManager->setConfig([
            'defaultConnection' => 'test',
            'entityPath'        => [ null ],
            'devMode'           => true,
            'connections' => [
                'test' => [
                    'driver'    => 'pdo_mysql',
                ]
            ]
        ]);

        $this->assertEquals(EntityManager::class, get_class($dbManager->getEntityManager()));
    }
}
