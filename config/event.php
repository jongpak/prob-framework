<?php

return [
    'Controller' => [
        '*.*' => [
            'before' => 'App\\EventListener\\Auth\\PermissionVerificationListener.validate'
        ],
        'Test.event' => [
            'before' => function () {
                echo '<p>before Hook!</p>';
            },
            'after' => function () {
                echo '<p>after Hook!</p>';
            }
        ]
    ]
];
