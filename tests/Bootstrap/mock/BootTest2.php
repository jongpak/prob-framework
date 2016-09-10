<?php

namespace App\Bootstrap;

use Core\Bootstrap\BootstrapInterface;

class BootTest2 implements BootstrapInterface
{
    public function boot()
    {
        echo 'test2';
    }
}
