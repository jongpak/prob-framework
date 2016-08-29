<?php

namespace Core\ControllerDispatcher;

use Prob\Router\Map;
use Core\ControllerDispatcher;

class RouterMapBuilder
{

    private $routerConfig = [];

    public function setRouterConfig(array $config)
    {
        $this->routerConfig = $config;
    }

    public function build()
    {
        $map = new Map();
        $map->setNamespace($this->routerConfig['namespace']);

        foreach ($this->getRoutePaths() as $k => $v) {
            $this->addRouterPath($map, $k, $v);
        }

        return $map;
    }

    private function getRoutePaths()
    {
        $paths = $this->routerConfig;
        unset($paths['namespace']);

        return $paths;
    }

    /**
     * $handlers schema
     *     (string) $handlers method or function name | {closure}
     *     (array) $handlers['GET' | 'POST'] => method or function name | {closure}
     *
     * @param Map    $routerMap
     * @param string $path  url path
     * @param string|array|closure $handlers
     */
    private function addRouterPath(Map $routerMap, $path, $handlers)
    {
        if ($this->resolveHttpGetHandler($handlers)) {
            $routerMap->get($path, $this->resolveHttpGetHandler($handlers));
        }

        if ($this->resolveHttpPostHandler($handlers)) {
            $routerMap->post($path, $this->resolveHttpPostHandler($handlers));
        }
    }

    private function resolveHttpGetHandler($handlers)
    {
        if (gettype($handlers) === 'string' || is_callable($handlers)) {
            return $handlers;
        }

        return isset($handlers['GET']) ? $handlers['GET'] : null;
    }

    private function resolveHttpPostHandler($handlers)
    {
        if (gettype($handlers) === 'string' || is_callable($handlers)) {
            return;
        }

        return isset($handlers['POST']) ? $handlers['POST'] : null;
    }
}
