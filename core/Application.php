<?php

namespace Core;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use JBZoo\Event\EventManager;
use Core\ControllerDispatcher\Dispatcher;
use Psr\Http\Message\ServerRequestInterface;

class Application
{
    private $siteConfig = [];

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

    public function getPublicUrl($url = '')
    {
        $url = $url === '/' ? '' : $url;
        return $this->siteConfig['publicPath'] . $url;
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
