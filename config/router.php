<?php

use Prob\Router\Map;

$map = new Map();
$map->setNamespace('App\\Controller');

$map->get('/', 'Home.index');
$map->get('/test', 'Test.echoTest');
$map->get('/test/json', 'Test.jsonTest');
$map->get('/test/db', 'Test.dbTest');
$map->get('/test/main', 'Test.goMain');
$map->get('/test/{name}', 'Test.paramTest');

return $map;
