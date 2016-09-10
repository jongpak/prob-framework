<?php

namespace App\Bootstrap;

use Core\Bootstrap\BootstrapInterface;
use Core\ErrorReporter\ErrorReporterRegister;

class ErrorReporterBootstrap implements BootstrapInterface
{
    public function boot(array $env)
    {
        ini_set('display_errors', $env['error']['displayErrors']);

        $register = new ErrorReporterRegister();
        $register->setConfig($env['error']);
        $register->register();
    }
}
