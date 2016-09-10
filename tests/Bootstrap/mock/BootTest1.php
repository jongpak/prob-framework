<?php

namespace App\Bootstrap;

use Core\Bootstrap\BootstrapInterface;

class BootTest1 implements BootstrapInterface
{
    public function boot()
    {
        echo 'test1';
    }
}
