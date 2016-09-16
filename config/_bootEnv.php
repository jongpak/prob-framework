<?php

return [
    'site' => require 'site.php',
    'auth' => require '../app/auth/config/config.php',
    'db' => require 'db.php',
    'viewEngine' => require 'viewEngine.php',
    'viewResolver' => require 'viewResolver.php',
    'router' => require 'router.php',
    'error' => require 'error.php',
    'event' => require 'event.php',
    'parameter' => require 'parameter.php',
];
