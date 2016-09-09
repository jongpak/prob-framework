<?php

namespace App\Bootstrap;

use Core\Bootstrap\BootstrapInterface;
use Core\ErrorReporterRegister;
use Core\Application;

class ErrorReporterBootstrap implements BootstrapInterface
{

    public function boot(Application $app)
    {
        $register = new ErrorReporterRegister();
        $register->setConfig($this->getConfig());
        $register->register();
    }

    private function getConfig()
    {
        return require __DIR__ . '/../../config/errorReporter.php';
    }
}
