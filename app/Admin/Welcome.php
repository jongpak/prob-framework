<?php

namespace App\Controller\Admin;

use Core\Application;
use Core\Utils\ArrayUtils;
use Core\ViewModel;
use Prob\ArrayUtil\KeyGlue;

class Welcome
{
    public function __construct(ViewModel $view, $urlPattern)
    {
        $view->set('nav', $urlPattern);
    }

    public function index(ViewModel $view)
    {
        $view->set('siteUrl', Application::getUrl());
        $view->set('sitePublicUrl', Application::getPublicUrl());

        $view->set('absolutePath', realpath(__DIR__ . '/../../'));
        $view->set('phpVersion', PHP_VERSION);
        $view->set('os', PHP_OS);
        $view->set('sapi', PHP_SAPI);

        return 'server';
    }

    public function viewRoutePaths(ViewModel $view)
    {
        $routePaths = AdminService::getRoutePaths();
        unset($routePaths['namespace']);

        $view->set('namespace', AdminService::getRoutePaths()['namespace']);
        $view->set('routePaths', $routePaths);

        return 'route';
    }

    public function viewEvents(ViewModel $view)
    {
        $glue = new KeyGlue();
        $glue->setGlueCharacter(' / ');
        $glue->setArray(AdminService::getEventHandlers());

        $events = $glue->glueKeyAndContainValue();

        foreach ($events as $k => $v) {
            if (is_string($events[$k]) == false) {
                $events[$k] = '{ Closure function }';
            }
        }

        $view->set('events', $events);

        return 'event';
    }
}