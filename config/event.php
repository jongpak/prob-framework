<?php

use Prob\Handler\ProcInterface;
use App\EventListener\Auth\Validator;

return [
    'Controller' => [
        '*.*' => [
            'before' => function (ProcInterface $proc) {
                $validator = new Validator(require '../app/EventListener/Auth/config/controllerPermission.php');
                $validator->validate($proc);
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
