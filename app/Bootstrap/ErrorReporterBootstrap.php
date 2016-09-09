<?php

namespace App\Bootstrap;

use Core\Bootstrap\BootstrapInterface;
use Core\ErrorReporterRegister;

class ErrorReporterBootstrap implements BootstrapInterface
{
    public function boot()
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
