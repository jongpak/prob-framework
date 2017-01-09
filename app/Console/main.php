<?php

require __DIR__ . '/../../vendor/autoload.php';

use Core\Bootstrap\Bootstrap;

(new Bootstrap(require __DIR__ . '/../../config/console/bootstrap.php'))
    ->boot(require __DIR__ . '/../../config/_consoleAppBootEnv.php');
