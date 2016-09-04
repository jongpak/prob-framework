<?php

return [
    'FileBaseAccountManager' => [
        'class' => 'App\\Auth\\AccountManeger\\FileBaseAccountManager',
        'settings' => [
            'accounts' => require 'accounts.php'
        ]
    ]
];
