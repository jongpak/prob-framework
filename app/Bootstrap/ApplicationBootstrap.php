<?php

namespace App\Bootstrap;

use App\Controller\Admin\AdminService;
use Core\Application;
use Core\Bootstrap\BootstrapInterface;

class ApplicationBootstrap implements BootstrapInterface
{
    public function boot(array $env)
    {
        Application::setConfig($env['site']);
        AdminService::setEnvironment($env);
    }
}
