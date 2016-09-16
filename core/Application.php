<?php

namespace Core;

use JBZoo\Event\EventManager;

class Application
{
    private static $config = [];

    public static function setConfig(array $config)
    {
        self::$config = $config;
    }

    /**
     * Return url path with site url
     * @param  string $url sub url
     * @return string
     */
    public static function getUrl($url = '')
    {
        return self::getPrefixUrl(self::$config['url'], $url);
    }

    public static function getPublicUrl($url = '')
    {
        return self::getPrefixUrl(self::$config['publicPath'], $url);
    }

    private static function getPrefixUrl($prefix, $path)
    {
        $prefix = $prefix . (substr($prefix, -1) !== '/' ? '/' : '');
        $path = substr($path, 0, 1) === '/' ? substr($path, 1) : $path;

        return $prefix . $path;
    }
}
