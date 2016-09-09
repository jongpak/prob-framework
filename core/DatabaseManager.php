<?php

namespace Core;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class DatabaseManager
{
    private $config = [];

    private function __construct()
    {
    }

    /**
     * @return self
     */
    public static function getInstance()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new self();
        }

        return $instance;
    }

    public function setConfig(array $config)
    {
        $this->config = $config;
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
}
