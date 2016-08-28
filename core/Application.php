<?php

namespace Core;

use Prob\Handler\ParameterMap;
use Prob\Router\Dispatcher;
use Prob\Rewrite\Request;
use Prob\Router\Map;
use Prob\Router\Matcher;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Core\ErrorReporter;
use \ErrorException;

class Application
{
    /**
     * @var Map
     */
    private $routerMap;

    private $routeConfig = [];
    private $siteConfig = [];
    private $errorReporterConfig = [];
    private $viewEngineConfig = [];
    private $dbConfig = [];

    private $errorReporters = [];

    /**
     * Singleton: private constructor
     */
    private function __construct()
    {
    }

    /**
     * @return Application
     */
    public static function getInstance()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new self();
        }

        return $instance;
    }

    public function setSiteConfig(array $siteConfig)
    {
        $this->siteConfig = $siteConfig;
    }

    public function setErrorReporterConfig(array $errorReporterConfig)
    {
        $this->errorReporterConfig = $errorReporterConfig;
    }

    public function setDbConfig(array $dbConfig)
    {
        $this->dbConfig = $dbConfig;
    }

    public function setViewEngineConfig(array $viewEngineConfig)
    {
        $this->viewEngineConfig = $viewEngineConfig;
    }

    public function setDisplayError($isDisplay)
    {
        error_reporting(E_ALL);
        ini_set('display_errors', $isDisplay);
    }

    public function registerErrorReporters()
    {
        $this->errorReporters = $this->getErrorReporterInstances();

        /**
         * @var ErrorReporter $reporter
         */
        set_exception_handler(function ($exception) {
            foreach ($this->errorReporters as $reporter) {
                $reporter->report($exception);
            }
        });

        set_error_handler(function ($errno, $errstr, $errfile, $errline, array $errcontext) {
            throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
        });
    }

    private function getErrorReporterInstances()
    {
        $enabledReporters = $this->siteConfig['errorReporters'];
        $errorReporters = [];

        foreach ($enabledReporters as $reporter) {
            $errorReporters[] = $this->buildErrorReporter($reporter);
        }

        return $errorReporters;
    }

    private function buildErrorReporter($reporterName)
    {
        $namespace = $this->errorReporterConfig['namespace'];
        $class = $namespace. '\\' . $reporterName;

        $setting = $this->errorReporterConfig[$reporterName];

        /* @var ErrorReporter */
        $reporter = new $class();
        $reporter->init($setting);

        return $reporter;
    }

    public function setRouterConfig(array $routeConfig)
    {
        $this->routeConfig = $routeConfig;
        $this->buildRouterMap();
    }

    private function buildRouterMap()
    {
        $routerMap = new Map();
        $routerMap->setNamespace($this->routeConfig['namespace']);

        foreach ($this->getRoutePathMap() as $k => $v) {
            $this->addRouterMap($routerMap, $k, $v);
        }

        $this->routerMap = $routerMap;
    }

    private function getRoutePathMap()
    {
        $paths = $this->routeConfig;
        unset($paths['namespace']);

        return $paths;
    }

    /**
     * @param Map    $routerMap
     * @param string $path  url path
     * @param string|array|closure $handler
     */
    private function addRouterMap(Map $routerMap, $path, $handler)
    {
        // string | closure
        if (gettype($handler) === 'string' || is_callable($handler)) {
            $routerMap->get($path, $handler);
            return;
        }

        /**
         * $handler array schema
         * (optional) $handler['GET' | 'POST']
         *                => method_name(ex. 'classname.methodname')
         *                    or function_name
         *                    or closure
         */
        if (isset($handler['GET'])) {
            $routerMap->get($path, $handler['GET']);
        }
        if (isset($handler['POST'])) {
            $routerMap->post($path, $handler['POST']);
        }
    }


    public function dispatcher(Request $request)
    {
        $url = $this->resolveUrl($request);
        $viewModel = new ViewModel();

        $parameterMap = new ParameterMap();
        $this->bindUrlParameter($parameterMap, $url);
        $this->bindViewModelParameter($parameterMap, $viewModel);

        $returnOfController = $this->executeController($request, $parameterMap);

        $view = $this->resolveView($returnOfController);
        $this->setViewVariables($view, $viewModel->getVariables());
        $view->render();
    }

    private function resolveUrl(Request $request)
    {
        $matcher = new Matcher($this->routerMap);
        return $matcher->match($request)['urlNameMatching'] ?: [];
    }

    private function executeController(Request $request, ParameterMap $parameterMap)
    {
        $dispatcher = new Dispatcher($this->routerMap);
        return $dispatcher->dispatch($request, $parameterMap);
    }

    /**
     * @param  mixed $returnOfController
     * @return View
     */
    private function resolveView($returnOfController)
    {
        $viewResolver = new ViewResolver($returnOfController);
        return $viewResolver->resolve($this->viewEngineConfig[$this->siteConfig['viewEngine']]);
    }

    private function bindUrlParameter(ParameterMap $map, array $url)
    {
        $map->bindByNameWithType('array', 'url', $url);

        foreach ($url as $name => $value) {
            $map->bindByName($name, $value);
        }
    }

    private function bindViewModelParameter(ParameterMap $map, ViewModel $viewModel)
    {
        $map->bindByType(ViewModel::class, $viewModel);
    }

    private function setViewVariables(View $view, array $var)
    {
        foreach ($var as $key => $value) {
            $view->set($key, $value);
        }
    }


    /**
     * Return url path with site url
     * @param  string $url sub url
     * @return string
     */
    public function url($url = '')
    {
        return $this->siteConfig['url'] . $url;
    }


    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        $config = Setup::createAnnotationMetadataConfiguration(
                    $this->dbConfig['entityPath'],
                    $this->dbConfig['devMode']
                    );
        return EntityManager::create($this->dbConfig[$this->siteConfig['database']], $config);
    }
}
