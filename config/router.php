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

$map->get('/{board}', function (array $url) {
    echo $url['board'];
});

return $map;