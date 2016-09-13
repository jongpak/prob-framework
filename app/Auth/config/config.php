<?php

return [
    'defaultAllow' => true,
    'defaultAccountManager' => 'FileBaseAccountManager',
    'defaultLoginManager' => 'SessionLoginManager',

    'accountManagers' => [
        'FileBaseAccountManager' => [
            'class' => 'App\\Auth\\AccountManager\\FileBaseAccountManager',
            'settings' => [
                'accounts' => require 'accounts.php'
            ]
        ]
    ],

    'loginManagers' => [
        'SessionLoginManager' => [
            'class' => 'App\\Auth\\LoginManager\\SessionLoginManager',
            'settings' => []
        ]
    ]
];
