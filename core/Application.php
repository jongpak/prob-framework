<?php

namespace Core;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use JBZoo\Event\EventManager;
use Core\ControllerDispatcher\Dispatcher;
use Psr\Http\Message\ServerRequestInterface;

class Application
{
    private $routerConfig = [];
    private $siteConfig = [];
    private $errorReporterConfig = [];
    private $viewEngineConfig = [];
    private $dbConfig = [];

    private $eventListeners = [];
    private $viewResolvers = [];

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

    public function setEventListener(array $eventListeners)
    {
        $this->eventListeners = $eventListeners;
    }

    public function setViewResolver(array $viewResolvers)
    {
        $this->viewResolvers = $viewResolvers;
    }

    public function setDisplayError($isDisplay)
    {
        error_reporting(E_ALL);
        ini_set('display_errors', $isDisplay);
    }

    public function registerErrorReporters()
    {
        $register = new ErrorReporterRegister();
        $register->setErrorReporterConfig($this->errorReporterConfig);
        $register->setEnabledReporters($this->siteConfig['errorReporters']);
        $register->register();
    }

    public function setRouterConfig(array $routerConfig)
    {
        $this->routerConfig = $routerConfig;
    }

    public function registerEventListener()
    {
        $register = new EventListenerRegister();
        $register->setEventListener($this->eventListeners);
        $register->register();
    }


    public function dispatch(ServerRequestInterface $request)
    {
        $dispatcher = new Dispatcher();

        $dispatcher->setRequest($request);
        $dispatcher->setRouterConfig($this->routerConfig);
        $dispatcher->setViewEngineConfig($this->viewEngineConfig);
        $dispatcher->setViewResolver($this->viewResolvers);

        $dispatcher->dispatch();
    }


    /**
     * Return url path with site url
     * @param  string $url sub url
     * @return string
     */
    public function url($url = '')
    {
        $url = $url === '/' ? '' : $url;
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

    /**
     * @return EventManager
     */
    public function getEventManager()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new EventManager();
        }

        return $instance;
    }
}
