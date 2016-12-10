<?php

namespace App\Bootstrap;

use Core\Bootstrap\BootstrapInterface;
use Core\ErrorReporter\ErrorReporterService;

class ErrorReporterBootstrap implements BootstrapInterface
{
    public function boot(array $env)
    {
        ini_set('display_errors', $env['error']['displayErrors']);

        $errorService = new ErrorReporterService();
        $errorService->setConfig($env['error']);
        $errorService->registerReport();
    }
}
