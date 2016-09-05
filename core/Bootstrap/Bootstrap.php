<?php

namespace Core\Bootstrap;

use Core\Application;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Uri;

class Bootstrap
{
    /**
     * @var Application
     */
    private $app;

    private $bootstraps = [];

    private $appUrl = '';

    public function __construct()
    {
        $this->app = Application::getInstance();
        $this->bootstraps = require __DIR__ . '/../../config/bootstrap.php';
    }

    public function boot()
    {
        foreach ($this->bootstraps as $bootstrapClassName) {
            /**
             * @var BootstrapInterface
             */
            $bootstrap = new $bootstrapClassName();
            $bootstrap->boot($this->app);

            if ($bootstrap instanceof SiteConfigLoader) {
                $this->appUrl = $bootstrap->getSiteConfig()['url'];
            }
        }

        $this->app->dispatch($this->getServerRequest());
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
        if (substr($url, 0, strlen($this->appUrl)) === $this->appUrl) {
            return '/' . substr($url, strlen($this->appUrl)) ?: '/';
        }

        return $url;
    }
}
