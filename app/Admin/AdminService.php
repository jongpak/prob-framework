<?php

namespace App\Controller\Admin;

class AdminService {
    private static $env;

    public static function setEnvironment(array $env)
    {
        self::$env = $env;
    }

    public static function getEnvironment($key = null)
    {
        return $key ? self::$env[$key] : self::$env;
    }

    public static function getRoutePaths()
    {
        return self::getEnvironment('router');
    }
}