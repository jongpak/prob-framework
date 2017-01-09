<?php

return [
    'site' => [
        'url' => '/',
        'publicPath' => realpath(__DIR__ . '/../') . DIRECTORY_SEPARATOR
    ],
    'auth' => require __DIR__ . '/../app/Auth/config/config.php',
    'hashProvider' => require __DIR__ . '/../app/Auth/config/hashProvider.php',
    'db' => require 'db.php',
    'viewEngine' => require 'console/viewEngine.php',
    'viewResolver' => require 'console/viewResolver.php',
    'viewPrefix' => require 'console/viewPrefix.php',
    'router' => require 'console/router.php',
    'error' => require 'console/error.php',
    'event' => require 'console/event.php',
    'parameter' => require 'parameter.php',
    'dispatcher' => require 'console/dispatcher.php',
];
