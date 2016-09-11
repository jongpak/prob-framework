<?php

use Prob\Handler\ProcInterface;
use App\EventListener\Auth\Validator;

return [
    'Controller' => [
        '*.*' => [
            'before' => 'App\\EventListener\\Auth\\ValidatorListener.validate'
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
