<?php

return [
    'Controller' => [
        '*.*' => [
            'before' => function () {
                echo '<p>before all!</p>';
            },
            'after' => function () {
                echo '<p>after all!</p>';
            }
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
