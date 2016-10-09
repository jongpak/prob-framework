<?php

namespace App\Bootstrap;

use Core\Bootstrap\BootstrapInterface;
use Core\ControllerDispatcher\Dispatcher;
use Core\ControllerDispatcher\ViewRenderer;
use Zend\Diactoros\Uri;
use Zend\Diactoros\ServerRequestFactory;

class DispatcherBootstrap implements BootstrapInterface
{
    public function boot(array $env)
    {
        $dispatcher = new Dispatcher();
        $viewRenderer = new ViewRenderer();

        $dispatcher->setRequest($this->getServerRequest($env['site']['url']));
        $dispatcher->setRouterConfig($env['router']);

        $viewRenderer->setViewEngineConfig($env['viewEngine']);
        $viewRenderer->setViewResolver($env['viewResolver']);
        $viewRenderer->setViewModel($dispatcher->getViewModel());

        $viewRenderer->renderView($dispatcher->dispatch());
    }

    private function getServerRequest($appUrl)
    {
        $request = ServerRequestFactory::fromGlobals();

        $stripedUri = new Uri(
            $this->stripAppUrlPrefix($request->getUri()->getPath(), $appUrl)
        );

        return $request->withUri($stripedUri);
    }

    private function stripAppUrlPrefix($url, $appUrl)
    {
        if (substr($url, 0, strlen($appUrl)) === $appUrl) {
            return '/' . substr($url, strlen($appUrl)) ?: '/';
        }

        return $url;
    }
}
