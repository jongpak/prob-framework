<?php

namespace App\Bootstrap;

use Core\Bootstrap\BootstrapInterface;

class BootTest3 implements BootstrapInterface
{
    public function boot(array $env)
    {
        echo $env['test3'];
    }
}
