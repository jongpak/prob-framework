<?php

namespace App\Auth;

class HashManager
{
    private static $providers = [];
    private static $defaultProviderName;

    public static function setConfig(array $config)
    {
        self::setProvider($config['hashProviders']);
        self::setDefaultProviderName($config['defaultHashProvider']);
    }

    /**
     * @param string $providerName
     * @return HashProviderInterface
     */
    public static function getProvider($providerName = '')
    {
        $providerName = $providerName ?: self::$defaultProviderName;

        $provider = self::$providers[$providerName];
        $settings = $provider['settings'];

        return new $provider['class']($settings);
    }

    public static function setProvider(array $providers)
    {
        self::$providers = $providers;
    }

    public static function setDefaultProviderName($providerName)
    {
        self::$defaultProviderName = $providerName;
    }
}