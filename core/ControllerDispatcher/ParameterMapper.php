<?php

namespace Core\ControllerDispatcher;

use Core\ParameterWire;
use Psr\Http\Message\ServerRequestInterface;
use Prob\Handler\ParameterMap;
use Prob\Handler\Parameter\Typed;
use Prob\Handler\Parameter\Named;
use Prob\Handler\Parameter\TypedAndNamed;
use Prob\Handler\ProcInterface;
use Prob\Router\Map;
use Core\ViewModel;
use Prob\Router\Matcher;

class ParameterMapper
{
    /**
     * @var ServerRequestInterface
     */
    private $request;

    /**
     * @var ViewModel
     */
    private $viewModel;

    /**
     * @var Map
     */
    private $routerMap;

    /**
     * @var ParameterMap
     */
    private $parameterMap;


    public function setRequest(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    public function setViewModel(ViewModel $viewModel)
    {
        $this->viewModel = $viewModel;
    }

    public function setRouterMap(Map $routerMap)
    {
        $this->routerMap = $routerMap;
    }

    /**
     * @return ParameterMap
     */
    public function getParameterMap()
    {
        $this->parameterMap = new ParameterMap();

        $this->bindRequest();
        $this->bindPatternedUrl();

        $this->bindNamedUrl();
        $this->bindViewModel();

        $this->bindProc();

        return ParameterWire::injectParameter($this->parameterMap);
    }

    private function bindRequest()
    {
        $this->parameterMap->bindBy(new Typed(ServerRequestInterface::class), $this->request);
    }

    private function bindPatternedUrl()
    {
        $matcher = new Matcher($this->routerMap);
        $urlPattern = $matcher->match($this->request)['urlPattern'];

        $this->parameterMap->bindBy(new Named('urlPattern'), $urlPattern);
    }

    private function bindNamedUrl()
    {
        $urlVariable = $this->resolveUrl();
        $this->parameterMap->bindBy(new TypedAndNamed('array', 'urlVariable'), $urlVariable);

        foreach ($urlVariable as $name => $value) {
            $this->parameterMap->bindBy(new Named($name), $value);
        }
    }

    private function bindProc()
    {
        $matcher = new Matcher($this->routerMap);
        $proc = $matcher->match($this->request)['handler'];

        $this->parameterMap->bindBy(new Typed(ProcInterface::class), $proc);
    }

    private function bindViewModel()
    {
        $this->parameterMap->bindBy(new Typed(ViewModel::class), $this->viewModel);
    }


    private function resolveUrl()
    {
        $matcher = new Matcher($this->routerMap);
        return $matcher->match($this->request)['urlNameMatching'] ?: [];
    }
}
