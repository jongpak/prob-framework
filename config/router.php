<?php

use Core\ViewModel;
use Prob\Router\Map;

$map = new Map();
$map->setNamespace('App\\Controller');

$map->get('/', function (array $url, ViewModel $viewModel) {
    $viewModel->set('time', date('r'));
    return 'default/main';
});

$map->get('/test', 'Test.hello');

$map->get('/{board}', function ($board) {
    $posts = [
        'board' => $board,
        'posts' => [
            [
                'title' => 'title 1',
                'title' => 'content 1'
            ],
            [
                'title' => 'title 2',
                'title' => 'content 2'
            ],
            [
                'title' => 'title 3',
                'title' => 'content 3'
            ]
        ]
    ];

    return $posts;
});

return $map;