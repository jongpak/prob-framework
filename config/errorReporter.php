<?php

return [
    'Html' => [
        'class' => 'App\\ErrorReporter\\Html',
        'view' => 'App\\ViewEngine\\Twig',
        'path' => '../view/error/',
        'file' => 'exception',
        'postfix' => '.twig',
        'settings' => []
    ]
];
