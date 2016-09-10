<?php

namespace App\Bootstrap;

use Core\Bootstrap\BootstrapInterface;

class BootTest3 implements BootstrapInterface
{
    public function boot()
    {
        echo 'test3';
    }
}
