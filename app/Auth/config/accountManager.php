<?php

return [
    'FileBaseAccountManager' => [
        'class' => 'App\\Auth\\AccountManager\\FileBaseAccountManager',
        'settings' => [
            'accounts' => require 'accounts.php'
        ]
    ]
];
