<?php

namespace Core\Bootstrap;

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Uri;

class Bootstrap
{
    private $bootstraps = [];

    public function __construct()
    {
        $this->bootstraps = require __DIR__ . '/../../config/bootstrap.php';
    }

    public function boot()
    {
        foreach ($this->bootstraps as $bootstrapClassName) {
            /**
             * @var BootstrapInterface
             */
            $bootstrap = new $bootstrapClassName();
            $bootstrap->boot();
        }
    }
}
