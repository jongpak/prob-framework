<?php

namespace Core\ControllerDispatcher;

use Prob\Router\Map;
use Prob\Router\Matcher;
use Psr\Http\Message\ServerRequestInterface;

class RequestMatcher
{
    /**
     * @var ServerRequestInterface
     */
    private static $request;

    /**
     * @var Map
     */
    private static $routerMap;

    public static function setRequest(ServerRequestInterface $request)
    {
        self::$request = $request;
    }

    public static function setRouterMap(Map $routerMap)
    {
        self::$routerMap = $routerMap;
    }

    public static function getRequest()
    {
        return self::$request;
    }

    public static function getUrlNameMatching()
    {
        return self::getControllerMatchingResult()['urlNameMatching'] ?: [];
    }

    public static function getPatternedUrl()
    {
        return self::getControllerMatchingResult()['urlPattern'];
    }

    public static function getControllerProc()
    {
        return self::getControllerMatchingResult()['handler'];
    }

    private static function getControllerMatchingResult()
    {
        return (new Matcher(self::$routerMap))->match(self::$request);
    }
}
