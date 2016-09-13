<?php

namespace Core;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class MockDatabaseManager extends DatabaseManager
{

    /**
     * @return EntityManager
     */
    public static function getEntityManager($connectionName = null)
    {
        $connectionName = $connectionName ?: self::$config['defaultConnection'];

        $config = Setup::createAnnotationMetadataConfiguration(
            self::$config['entityPath'],
            self::$config['devMode']
        );
        $entityManager = EntityManager::create(self::$config['connections'][$connectionName], $config);

        return $entityManager;
    }
}
