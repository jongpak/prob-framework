<?php

return [
    'namespace' => 'App\\ErrorReporter',

    'Html' => [
        'class' => 'Html',
        'view' => 'App\\ViewEngine\\Twig',
        'path' => '../view/error/',
        'file' => 'exception',
        'postfix' => '.twig',
        'settings' => []
    ]
];
