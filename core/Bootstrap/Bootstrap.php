<?php

namespace Core\Bootstrap;

use Core\Application;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Uri;

class Bootstrap
{
    /**
     * @var Application
     */
    private $app;

    private $bootstraps = [];

    public function __construct()
    {
        $this->app = Application::getInstance();
        $this->bootstraps = require __DIR__ . '/../../config/bootstrap.php';
    }

    public function boot()
    {
        foreach ($this->bootstraps as $bootstrapClassName) {
            /**
             * @var BootstrapInterface
             */
            $bootstrap = new $bootstrapClassName();
            $bootstrap->boot($this->app);
        }
    }
}
