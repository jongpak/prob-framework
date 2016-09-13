<?php

namespace Core;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

use \Exception;
use \RuntimeException;

class DatabaseManager
{
    protected static $config = [];

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

        try {
            $config = Setup::createAnnotationMetadataConfiguration(
                self::$config['entityPath'],
                self::$config['devMode']
            );
            $entityManager = EntityManager::create(self::$config['connections'][$connectionName], $config);
            $entityManager->getConnection()->connect();

            return $entityManager;
        } catch (Exception $e) {
            throw self::$config['devMode']
                ? new RuntimeException('Error raised when trying to connect database')
                : $e;
        }
    }
}
