<?php

namespace App\Auth;

class AuthManager
{
    private static $config = [];

    public static function setConfig(array $config)
    {
        self::$config = $config;
    }

    public static function isDefaultAllow()
    {
        return self::$config['defaultAllow'];
    }

    /**
     * @return AccountManagerInterface
     */
    public static function getAccountManager($accountManagerName = null)
    {
        $accountManagerName = $accountManagerName ?: self::$config['defaultAccountManager'];

        $className = self::$config['accountManagers'][$accountManagerName]['class'];
        $settings = self::$config['accountManagers'][$accountManagerName]['settings'];

        return new $className($settings);
    }

    /**
     * @return LoginManagerInterface
     */
    public static function getLoginManager($loginManagerName = null)
    {
        $loginManagerName = $loginManagerName ?: self::$config['defaultLoginManager'];

        $className = self::$config['loginManagers'][$loginManagerName]['class'];
        $settings = self::$config['loginManagers'][$loginManagerName]['settings'];

        return new $className($settings);
    }
}
