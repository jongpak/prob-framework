<?php

return [
    'displayErrors' => true,
    'enableReporters' => [ 'Stacktrace' ],

    'reporters' => [
        'Stacktrace' => [
            'class' => 'App\\ErrorReporter\\ConsoleStacktrace',

            'displayExceptionInfo' => true,
            'displayFileInfo' => true,
            'displayStackTrace' => true,
            'displayErrorSourceLines' => true,
        ]
    ],

    'errorCodes' => [

    ]
];
