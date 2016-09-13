<?php

namespace App\Bootstrap\Test;

use PHPUnit\Framework\TestCase;
use Core\Bootstrap\Bootstrap;
use Core\MockDatabaseManager;
use Doctrine\ORM\EntityManager;

class DatabaseBootstrapTest extends TestCase
{
    public function setUp()
    {
        require_once __DIR__ .'/../mock/MockDatabaseManager.php';
    }

    public function testBoot()
    {
        $bootstrap = new Bootstrap([
            'App\\Bootstrap\\DatabaseBootstrap',
        ]);
        $bootstrap->boot([
            'db' => [
                'defaultConnection' => 'test',
                'entityPath'        => [ null ],
                'devMode'           => true,
                'connections' => [
                    'test' => [ 'driver' => 'pdo_mysql' ]
                ]
            ]
        ]);

        $this->assertEquals(EntityManager::class, get_class(MockDatabaseManager::getEntityManager()));
    }
}
