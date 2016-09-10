<?php

return [
    'displayErrors' => true,
    'enableReporters' => [ 'Html' ],

    'reporters' => [
        'Html' => [
            'class' => 'App\\ErrorReporter\\Html',
            'view' => 'App\\ViewEngine\\TwigView',
            'path' => '../view/error/',
            'file' => 'exception',
            'postfix' => '.twig',
            'settings' => []
        ]
    ]
];
