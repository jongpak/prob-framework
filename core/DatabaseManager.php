<?php

namespace Core;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

use \Exception;
use \RuntimeException;

class DatabaseManager
{
    protected static $config = [];
    private static $entityManagers = [];

    public static function setConfig(array $config)
    {
        self::$config = $config;
    }

    /**
     * @return EntityManager
     */
    public static function getEntityManager($connectionName = null)
    {
        $connectionName = $connectionName ?: self::$config['defaultConnection'];

        if (isset(self::$entityManagers[$connectionName])) {
            return self::$entityManagers[$connectionName];
        }

        try {
            $config = Setup::createAnnotationMetadataConfiguration(
                self::$config['entityPath'],
                self::$config['devMode']
            );
            $entityManager = EntityManager::create(self::$config['connections'][$connectionName], $config);
            $entityManager->getConnection()->connect();

            self::$entityManagers[$connectionName] = $entityManager;

            return $entityManager;
        } catch (Exception $e) {
            throw self::$config['devMode']
                ? $e
                : new RuntimeException('Error raised when trying to connect database');
        }
    }
}
