<?php

use Prob\Router\Map;

$map = new Map();
$map->setNamespace('App\\Controller');

$map->get('/', 'Home.index');
$map->get('/test', 'Test.hello');
$map->get('/{board:string}', 'Test.showPostList');

return $map;
