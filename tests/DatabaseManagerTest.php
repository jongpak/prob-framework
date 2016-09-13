<?php

namespace Core;

use PHPUnit\Framework\TestCase;
use Core\DatabaseManager;
use Doctrine\ORM\EntityManager;

class DatabaseManagerTest extends TestCase
{
    public function testGetDefaultEntityManager()
    {
        DatabaseManager::setConfig([
            'defaultConnection' => 'test',
            'entityPath'        => [ null ],
            'devMode'           => true,
            'connections' => [
                'test' => [
                    'driver'    => 'pdo_mysql',
                ]
            ]
        ]);

        $this->assertEquals(EntityManager::class, get_class(DatabaseManager::getEntityManager()));
    }

    public function testGetUserEntityManager()
    {
        $dbManager = new DatabaseManager;
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
