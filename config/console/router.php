<?php

use App\Controller\Admin\AdminService;

return [
    'namespace' => '',

    '/help' => function() {
        echo 'Commands: ' . PHP_EOL;
        foreach(AdminService::getEnvironment('router') as $path => $proc) {
            if($path === 'namespace') {
                continue;
            }

            echo '  - [' . $path . ']' . PHP_EOL;
            echo '     => ' . get_class($proc) . PHP_EOL . PHP_EOL;
        }
    },

    '/hello' => function() {
        echo 'hello!' . PHP_EOL;
        echo 'ㅋㅋㅋㅋ 프로브가 콘솔을 정복!!';
    }
];