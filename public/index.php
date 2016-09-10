<?php

require '../vendor/autoload.php';

use Core\Bootstrap\Bootstrap;

(new Bootstrap(require __DIR__ . '/../config/bootstrap.php'))
    ->boot(require __DIR__ . '/../config/_bootEnv.php');
