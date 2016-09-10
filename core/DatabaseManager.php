<?php

namespace Core;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class DatabaseManager
{
    private $config = [];
    private static $defaultConfig = [];

    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    public static function setDefaultConfig(array $config)
    {
        self::$defaultConfig = $config;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        $config = Setup::createAnnotationMetadataConfiguration(
                    $this->config['entityPath'],
                    $this->config['devMode']
                    );
        return EntityManager::create($this->config['connections'][$this->config['defaultConnection']], $config);
    }

    /**
     * @return EntityManager
     */
    public static function getDefaultEntityManager()
    {
        $config = Setup::createAnnotationMetadataConfiguration(
                    self::$defaultConfig['entityPath'],
                    self::$defaultConfig['devMode']
                    );
        return EntityManager::create(self::$defaultConfig['connections'][self::$defaultConfig['defaultConnection']], $config);
    }
}
