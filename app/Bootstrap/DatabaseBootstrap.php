<?php

namespace App\Bootstrap;

use Core\Bootstrap\BootstrapInterface;
use Core\DatabaseManager;

class DatabaseBootstrap implements BootstrapInterface
{
    public function boot()
    {
        $dbManager = DatabaseManager::getInstance();
        $dbManager->setConfig($this->getConfig());
    }

    private function getConfig()
    {
        return require __DIR__ . '/../../config/db.php';
    }
}
