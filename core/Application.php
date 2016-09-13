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
        $url = $url === '/' ? '' : $url;
        return self::$config['url'] . $url;
    }

    public static function getPublicUrl($url = '')
    {
        $url = $url === '/' ? '' : $url;
        return self::$config['publicPath'] . $url;
    }
}
