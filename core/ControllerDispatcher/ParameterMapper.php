<?php

namespace Core\ControllerDispatcher;

use Prob\Rewrite\Request;
use Prob\Handler\ParameterMap;
use Prob\Router\Map;
use Core\ViewModel;
use Prob\Router\Matcher;

class ParameterMapper
{

    /**
     * @var Request
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


    public function setRequest(Request $request)
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
        
        $this->bindUrl();
        $this->bindViewModel();

        return $this->parameterMap;
    }

    private function bindUrl()
    {
        $url = $this->resolveUrl($this->request);
        $this->parameterMap->bindByNameWithType('array', 'url', $url);

        foreach ($url as $name => $value) {
            $this->parameterMap->bindByName($name, $value);
        }
    }

    private function bindViewModel()
    {
        $this->parameterMap->bindByType(ViewModel::class, $this->viewModel);
    }


    private function resolveUrl()
    {
        $matcher = new Matcher($this->routerMap);
        return $matcher->match($this->request)['urlNameMatching'] ?: [];
    }
}
