<?php

return [
    'displayErrors' => true,
    'enableReporters' => [ 'Html' ],

    'reporters' => [
        'Html' => [
            'class' => 'App\\ErrorReporter\\Html',
            'view' => 'App\\ViewEngine\\TwigView',
            'path' => __DIR__ . '/../view/error/',
            'file' => 'exception',
            'postfix' => '.twig',
            'settings' => []
        ]
    ]
];
