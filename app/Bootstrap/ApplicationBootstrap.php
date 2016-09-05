<?php

namespace App\Bootstrap;

use Core\Application;
use Core\Bootstrap\BootstrapInterface;
use Core\Bootstrap\SiteConfigLoader;

class ApplicationBootstrap implements BootstrapInterface, SiteConfigLoader
{

    public function boot(Application $app)
    {
        $app->setSiteConfig($this->getSiteConfig());
        $app->setErrorReporterConfig($this->getErrorReporterConfig());
        $app->setDbConfig($this->getDbConfig());

        $app->setViewEngineConfig($this->getViewEngineConfig());
        $app->setViewResolver($this->getViewResolvers());

        $app->setDisplayError($this->getSiteConfig()['displayErrors']);
        $app->registerErrorReporters();

        $app->setEventListener($this->getEventListener());
        $app->registerEventListener();

        $app->setRouterConfig($this->getRouterConfig());
    }

    public function getSiteConfig()
    {
        return require __DIR__ . '/../../config/site.php';
    }

    private function getErrorReporterConfig()
    {
        return require __DIR__ . '/../../config/errorReporter.php';
    }

    private function getDbConfig()
    {
        return require __DIR__ . '/../../config/db.php';
    }

    private function getViewEngineConfig()
    {
        return require __DIR__ . '/../../config/viewEngine.php';
    }

    private function getViewResolvers()
    {
        return require __DIR__ . '/../../config/viewResolver.php';
    }

    private function getEventListener()
    {
        return require __DIR__ . '/../../config/event.php';
    }

    private function getRouterConfig()
    {
        return require __DIR__ . '/../../config/router.php';
    }
}
