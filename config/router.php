<?php

return [
    'namespace' => 'App\\Controller',

    '/' => 'Welcome.index',

    '/test' => 'Test.echoTest',
    '/test/json' => 'Test.jsonTest',
    '/test/db' => 'Test.dbTest',
    '/test/main' => 'Test.goMain',
    '/test/event' => 'Test.event',
    '/test/{name}' => 'Test.paramTest',
];
