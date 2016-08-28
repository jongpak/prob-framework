<?php

namespace App;

use Core\Application;
use Prob\Rewrite\Request;

class Bootstrap
{

    public static function boot()
    {
        $application = Application::getInstance();

        $application->setSiteConfig(self::getSiteConfig());
        $application->setErrorReporterConfig(self::getErrorReporterConfig());
        $application->setDbConfig(self::getDbConfig());
        $application->setViewEngineConfig(self::getViewEngineConfig());

        $application->setDisplayError(self::getSiteConfig()['displayErrors']);
        $application->registerErrorReporters();

        $application->setRouterConfig(self::getRouterConfig());
        $application->dispatcher(new Request());
    }

    public static function getSiteConfig()
    {
        return require '../config/site.php';
    }

    public static function getErrorReporterConfig()
    {
        return require '../config/errorReporter.php';
    }

    public static function getDbConfig()
    {
        return require '../config/db.php';
    }

    public static function getViewEngineConfig()
    {
        return require '../config/viewEngine.php';
    }

    public static function getRouterConfig()
    {
        return require '../config/router.php';
    }
}
