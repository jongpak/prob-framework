<?php

return [
    'namespace' => 'App\\Controller',

    '/' => 'Welcome.index',

    '/auth/login' => [
        'GET' => 'Auth.viewLoginForm',
        'POST' => 'Auth.doLogin'
    ],
    '/auth/logout' => 'Auth.doLogout',

    '/admin' => 'Admin\\Welcome.index',
    '/admin/route' => 'Admin\\Welcome.viewRoutePaths',
    '/admin/event' => 'Admin\\Welcome.viewEvents',

    '/test' => 'Test.echoTest',
    '/test/json' => 'Test.jsonTest',
    '/test/db' => 'Test.dbTest',
    '/test/main' => 'Test.goMain',
    '/test/event' => 'Test.event',
    '/test/admin' => 'Test.admin',
    '/test/{name}' => 'Test.paramTest',
];
