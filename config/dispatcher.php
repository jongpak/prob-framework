<?php

use Zend\Diactoros\ServerRequestFactory;

return [
    'request' => ServerRequestFactory::fromGlobals(),
];