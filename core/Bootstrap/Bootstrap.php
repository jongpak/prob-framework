<?php

namespace Core\Bootstrap;

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Uri;

class Bootstrap
{
    private $bootstraps = [];

    public function __construct(array $bootstraps)
    {
        $this->bootstraps = $bootstraps;
    }

    public function boot(array $env)
    {
        foreach ($this->bootstraps as $bootstrapClassName) {
            /** @var BootstrapInterface */
            $bootstrap = new $bootstrapClassName();
            $bootstrap->boot($env);
        }
    }
}
