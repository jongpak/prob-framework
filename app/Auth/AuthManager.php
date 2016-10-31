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
        return self::getManagerInstance('account', $accountManagerName);
    }

    /**
     * @return LoginManagerInterface
     */
    public static function getLoginManager($loginManagerName = null)
    {
        return self::getManagerInstance('login', $loginManagerName);
    }

    /**
     * @return PermissionManagerAbstract
     */
    public static function getPermissionManager($loginManagerName = null)
    {
        return self::getManagerInstance('permission', $loginManagerName);
    }

    private static function getManagerInstance($managerType, $managerName = null)
    {
        $managerInstanceName = $managerName ?: self::$config['default' . ucfirst($managerType) . 'Manager'];

        $className = self::$config[$managerType . 'Managers'][$managerInstanceName]['class'];
        $settings = self::$config[$managerType . 'Managers'][$managerInstanceName]['settings'];

        return new $className($settings);
    }
}
