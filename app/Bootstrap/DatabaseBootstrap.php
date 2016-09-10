<?php

namespace App\Bootstrap;

use Core\Bootstrap\BootstrapInterface;
use Core\DatabaseManager;

class DatabaseBootstrap implements BootstrapInterface
{
    public function boot()
    {
        DatabaseManager::setDefaultConfig($this->getConfig());
    }

    private function getConfig()
    {
        return require __DIR__ . '/../../config/db.php';
    }
}