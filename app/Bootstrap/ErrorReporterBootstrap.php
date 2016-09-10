<?php

namespace App\Bootstrap;

use Core\Bootstrap\BootstrapInterface;
use Core\ErrorReporter\ErrorReporterRegister;

class ErrorReporterBootstrap implements BootstrapInterface
{
    public function boot()
    {
        ini_set('display_errors', $this->getConfig()['displayErrors']);

        $register = new ErrorReporterRegister();
        $register->setConfig($this->getConfig());
        $register->register();
    }

    private function getConfig()
    {
        return require __DIR__ . '/../../config/error.php';
    }
}
