<?php

use Prob\Handler\Parameter\Named;
use Prob\Handler\Parameter\Typed;
use Prob\Handler\Parameter\TypedAndNamed;
use Prob\Handler\ProcInterface;
use Core\ParameterWire;
use Psr\Http\Message\ServerRequestInterface;
use Core\ControllerDispatcher\RequestMatcher;
use Zend\Diactoros\ServerRequestFactory;
use App\Auth\AuthManager;
use App\Auth\LoginManagerInterface;
use App\Auth\AccountManagerInterface;
use App\ViewResolver\ResponseResolver;
use Doctrine\ORM\EntityManagerInterface;
use Core\DatabaseManager;
use Core\Utils\ResponseProxy;

return [
    [
        'key' => new Typed(ServerRequestInterface::class),
        'value' => ParameterWire::post(function () {
            return RequestMatcher::getRequest();
        })
    ],
    [
        'key' => new Typed(ResponseProxy::class),
        'value' => ResponseResolver::getResponseProxyInstance()
    ],
    [
        'key' => new Named('urlPattern'),
        'value' =>  ParameterWire::post(function () {
            return RequestMatcher::getPatternedUrl();
        })
    ],
    [
        'key' => new TypedAndNamed('array', 'urlVariable'),
        'value' =>  ParameterWire::post(function () {
            return RequestMatcher::getUrlNameMatching();
        })
    ],
    ParameterWire::postCallback(function () {
        $result = [];
        foreach (RequestMatcher::getUrlNameMatching() as $name => $value) {
            $result[] = [
                'key' => new Named($name),
                'value' => $value
            ];
        }
        return $result;
    }),
    [
        'key' => new Typed(ProcInterface::class),
        'value' =>  ParameterWire::post(function () {
            return RequestMatcher::getControllerProc();
        })
    ],
    [
        'key' => new Named('parsedBody'),
        'value' => ServerRequestFactory::fromGlobals()->getParsedBody()
    ],
    [
        'key' => new Typed(AccountManagerInterface::class),
        'value' => ParameterWire::post(function () {
            return AuthManager::getAccountManager();
        })
    ],
    [
        'key' => new Typed(LoginManagerInterface::class),
        'value' => ParameterWire::post(function () {
            return AuthManager::getLoginManager();
        })
    ],
    [
        'key' => new Typed(EntityManagerInterface::class),
        'value' => ParameterWire::post(function () {
            return DatabaseManager::getEntityManager();
        })
    ],
];
