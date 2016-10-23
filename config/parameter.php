<?php

use Prob\Handler\ProcInterface;
use Psr\Http\Message\ServerRequestInterface;
use Core\ControllerDispatcher\RequestMatcher;
use Core\Utils\Parameter\Parameter as P;
use App\Auth\AuthManager;
use App\Auth\LoginManagerInterface;
use App\Auth\AccountManagerInterface;
use App\ViewResolver\ResponseResolver;
use Doctrine\ORM\EntityManagerInterface;
use Core\DatabaseManager;
use Core\Utils\ResponseProxy;
use Zend\Diactoros\ServerRequestFactory;

return [
    P::type(ServerRequestInterface::class)
        ->lazy(function() { return RequestMatcher::getRequest(); }),

    P::type(ResponseProxy::class)
        ->value(ResponseResolver::getResponseProxyInstance()),

    P::name('urlPattern')
        ->lazy(function() { return RequestMatcher::getPatternedUrl(); }),

    P::name('parsedBody')
        ->value(ServerRequestFactory::fromGlobals()->getParsedBody()),

    P::typeAndName('array', 'urlVariable')
        ->lazy(function() { return RequestMatcher::getUrlNameMatching(); }),

    P::type(ProcInterface::class)
        ->lazy(function() { return RequestMatcher::getControllerProc(); }),

    P::type(AccountManagerInterface::class)
        ->lazy(function() { return AuthManager::getAccountManager(); }),

    P::type(LoginManagerInterface::class)
        ->lazy(function() { return AuthManager::getLoginManager(); }),

    P::type(EntityManagerInterface::class)
        ->lazy(function() { return DatabaseManager::getEntityManager(); }),

    P::lazyCallback(function () {
        $result = [];
        foreach (RequestMatcher::getUrlNameMatching() as $name => $value) {
            $result[] = P::name($name)->value($value);
        }
        return $result;
    })
];
