<?php

return [
    'defaultHashProvider' => 'BCryptHashProvider',

    'hashProviders' => [
        'BCryptHashProvider' => [
            'class' => 'App\\Auth\\HashProvider\\BCryptHashProvider',
            'settings' => []
        ]
    ]
];