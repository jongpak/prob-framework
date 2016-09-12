<?php

namespace Core;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class DatabaseManager
{
    private static $config = [];

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

        $config = Setup::createAnnotationMetadataConfiguration(
            self::$config['entityPath'],
            self::$config['devMode']
        );
        return EntityManager::create(self::$config['connections'][$connectionName], $config);
    }
}
