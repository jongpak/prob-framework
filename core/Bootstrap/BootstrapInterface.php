<?php

namespace Core\Bootstrap;

use Core\Application;

interface BootstrapInterface
{

    public function boot(Application $app);
}
