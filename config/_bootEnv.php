<?php

return [
    'site' => require 'site.php',

    'auth' => require '../app/auth/config/config.php',
    'accountManager' => require '../app/auth/config/accountManager.php',
    'loginManager' => require '../app/auth/config/loginManager.php',

    'db' => require 'db.php',
    'viewEngine' => require 'viewEngine.php',
    'viewResolver' => require 'viewResolver.php',
    'router' => require 'router.php',
    'error' => require 'error.php',
    'event' => require 'event.php',
];
