<?php

use Prob\Router\Map;

$map = new Map();
$map->setNamespace('App\\Controller');

$map->get('/', function (array $url) {
    return 'default/main';
});

$map->get('/test', 'Test.hello');

$map->get('/{board}', function ($url) {
    echo $url['board'];
});

return $map;