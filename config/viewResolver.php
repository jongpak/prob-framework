<?php

return [
    'App\ViewResolver\ResponseResolver',
    'App\ViewResolver\DummyResolver',
    'App\ViewResolver\RedirectResolver',
    'Twig' => 'App\ViewResolver\TwigResolver',
    'App\ViewResolver\JsonResolver',
];
