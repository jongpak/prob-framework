<?php

use Zend\Diactoros\ServerRequest;

return [
    'request' => (function() {
        if(isset($_SERVER['argv'][1]) === false) {
            exit(1);
        }
        return new ServerRequest($_SERVER, [], $_SERVER['argv'][1]);
    })(),
];