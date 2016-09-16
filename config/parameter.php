<?php

use Prob\Handler\Parameter\Named;
use Prob\Handler\Parameter\Typed;
use Prob\Handler\Parameter\TypedAndNamed;

return [
    [
        'key' => new Named('parsedBody'),
        'value' => \Zend\Diactoros\ServerRequestFactory::fromGlobals()->getParsedBody()
    ],
];
