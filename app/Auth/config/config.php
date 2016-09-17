<?php

return [
    'defaultAllow' => true,
    'defaultAccountManager' => 'FileBaseAccountManager',
    'defaultLoginManager' => 'SessionLoginManager',
    'defaultPermissionManager' => 'FileBasePermissionManager',

    'accountManagers' => [
        'FileBaseAccountManager' => [
            'class' => 'App\\Auth\\AccountManager\\FileBaseAccountManager',
            'settings' => [
                'accounts' => require 'accounts.php'
            ]
        ],
        'DatabaseAccountManager' => [
            'class' => 'App\\Auth\\AccountManager\\DatabaseAccountManager',
            'settings' => []
        ]
    ],

    'loginManagers' => [
        'SessionLoginManager' => [
            'class' => 'App\\Auth\\LoginManager\\SessionLoginManager',
            'settings' => []
        ]
    ],

    'permissionManagers' => [
        'FileBasePermissionManager' => [
            'class' => 'App\\Auth\\PermissionManager\\FileBasePermissionManager',
            'settings' => [
                'permissions' => require 'permission.php'
            ]
        ]
    ]
];
