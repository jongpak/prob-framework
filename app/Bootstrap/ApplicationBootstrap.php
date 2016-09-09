<?php

namespace App\Bootstrap;

use Core\Application;
use Core\Bootstrap\BootstrapInterface;

class ApplicationBootstrap implements BootstrapInterface
{

    public function boot(Application $app)
    {
        $app->setSiteConfig($this->getSiteConfig());
    }

    public function getSiteConfig()
    {
        return require __DIR__ . '/../../config/site.php';
    }
}
