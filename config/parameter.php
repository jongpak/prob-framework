<?php

use Prob\Handler\Parameter\Named;
use Prob\Handler\Parameter\Typed;
use Prob\Handler\Parameter\TypedAndNamed;
use Core\ParameterWire;

return [
    [
        'key' => new Named('parsedBody'),
        'value' => \Zend\Diactoros\ServerRequestFactory::fromGlobals()->getParsedBody()
    ],
    [
        'key' => new Typed(\App\Auth\AccountManagerInterface::class),
        'value' => ParameterWire::post(function() {
            return \App\Auth\AuthManager::getAccountManager();
        })
    ],
    [
        'key' => new Typed(\App\Auth\LoginManagerInterface::class),
        'value' => ParameterWire::post(function() {
            return \App\Auth\AuthManager::getLoginManager();
        })
    ],
    [
        'key' => new Typed(\Doctrine\ORM\EntityManagerInterface::class),
        'value' => ParameterWire::post(function() {
            return \Core\DatabaseManager::getEntityManager();
        })
    ],
];
