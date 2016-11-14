<?php

namespace Core\ControllerDispatcher;

use PHPUnit\Framework\TestCase;
use Prob\Handler\Proc\ClosureProc;
use Prob\Handler\Proc\FunctionProc;
use Prob\Router\Map;
use Zend\Diactoros\Server;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Uri;

class RequestMatcherTest extends TestCase
{
    public function testGetSetRequest()
    {
        $request = new ServerRequest();

        RequestMatcher::setRequest($request);

        $this->assertEquals($request, RequestMatcher::getRequest());
    }

    public function testGetUrlNameMatching()
    {
        $request = new ServerRequest([], [], new Uri('/account/test'), 'GET');
        $routeMap = new Map();
        $routeMap->get('/account/{id}', function() { });

        RequestMatcher::setRequest($request);
        RequestMatcher::setRouterMap($routeMap);

        $this->assertEquals(['id' => 'test'], RequestMatcher::getUrlNameMatching());
    }

    public function testGetPatternedUrl()
    {
        $request = new ServerRequest([], [], new Uri('/account/test'), 'GET');
        $routeMap = new Map();
        $routeMap->get('/account/{id}', function() { });

        RequestMatcher::setRequest($request);
        RequestMatcher::setRouterMap($routeMap);

        $this->assertEquals('/account/{id}', RequestMatcher::getPatternedUrl());
    }

    public function testGetControllerProc()
    {
        $request = new ServerRequest([], [], new Uri('/account/test'), 'GET');

        $proc = function($arg) {
            return $arg;
        };
        $routeMap = new Map();
        $routeMap->get('/account/{id}', $proc);

        RequestMatcher::setRequest($request);
        RequestMatcher::setRouterMap($routeMap);

        $this->assertEquals('hello', RequestMatcher::getControllerProc()->exec('hello'));
    }
}