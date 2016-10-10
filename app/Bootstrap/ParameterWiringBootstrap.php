<?php

namespace App\Bootstrap;

use Core\Bootstrap\BootstrapInterface;
use Core\LazyWiringParameterCallback;
use Core\ParameterWire;

class ParameterWiringBootstrap implements BootstrapInterface
{
    public function boot(array $env)
    {
        foreach ($env['parameter'] as $v) {
            if ($v instanceof LazyWiringParameterCallback) {
                ParameterWire::appendParameterCallback($v);
                continue;
            }

            ParameterWire::appendParameter($v['key'], $v['value']);
        }
    }
}
