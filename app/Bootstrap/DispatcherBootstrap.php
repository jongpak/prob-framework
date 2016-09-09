<?php

namespace App\Bootstrap;

use Core\Bootstrap\BootstrapInterface;
use Core\ControllerDispatcher\Dispatcher;
use Zend\Diactoros\Uri;
use Zend\Diactoros\ServerRequestFactory;

class DispatcherBootstrap implements BootstrapInterface
{
    public function boot()
    {
        $dispatcher = new Dispatcher();

        $dispatcher->setRequest($this->getServerRequest());
        $dispatcher->setRouterConfig($this->getRouterConfig());
        $dispatcher->setViewEngineConfig($this->getViewEngineConfig());
        $dispatcher->setViewResolver($this->getViewResolvers());

        $dispatcher->dispatch();
    }

    private function getServerRequest()
    {
        $request = ServerRequestFactory::fromGlobals();

        $stripedUri = new Uri(
            $this->stripUrlPrefix($request->getUri()->getPath())
        );

        return $request->withUri($stripedUri);
    }

    private function stripUrlPrefix($url)
    {
        $appUrl = $this->getSiteConfig()['url'];

        if (substr($url, 0, strlen($appUrl)) === $appUrl) {
            return '/' . substr($url, strlen($appUrl)) ?: '/';
        }

        return $url;
    }

    private function getSiteConfig()
    {
        return require __DIR__ . '/../../config/site.php';
    }

    private function getViewEngineConfig()
    {
        return require __DIR__ . '/../../config/viewEngine.php';
    }

    private function getViewResolvers()
    {
        return require __DIR__ . '/../../config/viewResolver.php';
    }

    private function getRouterConfig()
    {
        return require __DIR__ . '/../../config/router.php';
    }
}
