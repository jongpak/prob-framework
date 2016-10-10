<?php

namespace App\Bootstrap;

use Core\Bootstrap\BootstrapInterface;
use Core\ControllerDispatcher\Dispatcher;
use Core\ControllerDispatcher\ViewRenderer;
use Core\ControllerDispatcher\ParameterMapper;
use Core\ControllerDispatcher\RouterMapBuilder;
use Core\ViewModel;
use Zend\Diactoros\Uri;
use Zend\Diactoros\ServerRequestFactory;

class DispatcherBootstrap implements BootstrapInterface
{
    private $env = [];

    /**
     * @var ViewModel
     */
    private $viewModel;

    public function __construct()
    {
        $this->viewModel = new ViewModel();
    }

    public function boot(array $env)
    {
        $this->env = $env;

        $dispatcher = $this->getDispatcher();
        $viewRenderer = $this->getViewRenderer();

        $viewRenderer->renderView($dispatcher->dispatch());
    }

    private function getDispatcher()
    {
        $dispatcher = new Dispatcher();

        $dispatcher->setRequest($this->getServerRequest());
        $dispatcher->setRouterMap($this->getRouterMap());
        $dispatcher->setParameterMap($this->getParameterMap());

        return $dispatcher;
    }

    private function getViewRenderer()
    {
        $viewRenderer = new ViewRenderer();

        $viewRenderer->setViewEngineConfig($this->env['viewEngine']);
        $viewRenderer->setViewResolver($this->env['viewResolver']);
        $viewRenderer->setViewModel($this->viewModel);

        return $viewRenderer;
    }

    private function getParameterMap()
    {
        $parameterMapper = new ParameterMapper();

        $parameterMapper->setRequest($this->getServerRequest());
        $parameterMapper->setViewModel($this->viewModel);
        $parameterMapper->setRouterMap($this->getRouterMap());

        return $parameterMapper->getParameterMap();
    }

    private function getServerRequest()
    {
        $request = ServerRequestFactory::fromGlobals();

        $stripedUri = new Uri(
            $this->stripAppUrlPrefix($request->getUri()->getPath())
        );

        return $request->withUri($stripedUri);
    }

    private function stripAppUrlPrefix($url)
    {
        $appUrl = $this->env['site']['url'];

        if (substr($url, 0, strlen($appUrl)) === $appUrl) {
            return '/' . substr($url, strlen($appUrl)) ?: '/';
        }

        return $url;
    }

    private function getRouterMap()
    {
        return (new RouterMapBuilder($this->env['router']))->build();
    }
}
