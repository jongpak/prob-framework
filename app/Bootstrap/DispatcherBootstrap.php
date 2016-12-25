<?php

namespace App\Bootstrap;

use Core\Bootstrap\BootstrapInterface;
use Core\ControllerDispatcher\Dispatcher;
use Core\ControllerDispatcher\ViewRenderer;
use Core\ControllerDispatcher\RequestMatcher;
use Core\ControllerDispatcher\RouterMapBuilder;
use Core\ParameterWire;
use Core\Utils\ArrayUtils;
use Core\ViewModel;
use Zend\Diactoros\Uri;
use Zend\Diactoros\ServerRequestFactory;
use Prob\Handler\ParameterMap;
use Prob\Handler\Parameter\Typed;

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

        RequestMatcher::setRequest($this->getServerRequest());
        RequestMatcher::setRouterMap($this->getRouterMap());

        $dispatcher = $this->getDispatcher();
        $viewRenderer = $this->getViewRenderer();

        $controllerResult = $this->getControllerResult($viewRenderer, $dispatcher->dispatch());

        echo $viewRenderer->renderView($controllerResult);
    }

    private function getControllerResult(ViewRenderer $viewRenderer, $controllerResult)
    {
        $viewClassName = get_class($viewRenderer->resolveView($controllerResult));

        if(array_search($viewClassName, $this->env['viewPrefix']['applyView']) === false) {
            return $controllerResult;
        }

        return $this->getViewPrefix() . $controllerResult;
    }

    private function getViewPrefix()
    {
        $prefix = $this->env['viewPrefix']['controller'];
        $defaultPrefix = $this->env['viewPrefix']['default'];

        $controllerName = RequestMatcher::getControllerProc()->getName();

        $matchedViewPrefixKey = ArrayUtils::find(array_keys($prefix), $controllerName);

        return $matchedViewPrefixKey ? $prefix[$matchedViewPrefixKey] : $defaultPrefix;
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
        $parameterMap = new ParameterMap();
        $parameterMap->bindBy(new Typed(ViewModel::class), $this->viewModel);
        return ParameterWire::injectParameter($parameterMap);
    }

    private function getServerRequest()
    {
        $request = $this->env['dispatcher']['request'];

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
