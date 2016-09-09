<?php

namespace App\Auth;

class AuthManager
{
    private $config = [];

    private $accountManagerConfig = [];
    private $loginManagerConfig = [];

    private function __construct()
    {
    }

    /**
     * @return self
     */
    public static function getInstance()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new self();
        }

        return $instance;
    }


    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    public function setAccountManagerConfig(array $config)
    {
        $this->accountManagerConfig = $config;
    }

    public function setLoginManagerConfig(array $config)
    {
        $this->loginManagerConfig = $config;
    }


    public function isDefaultAllow()
    {
        return $this->config['defaultAllow'];
    }

    /**
     * @return AccountManagerInterface
     */
    public function getDefaultAccountManager()
    {
        $defaultAccountManagerConfig = $this->accountManagerConfig[$this->config['defaultAccountManager']];

        $className = $defaultAccountManagerConfig['class'];
        $settings = $defaultAccountManagerConfig['settings'];

        return new $className($settings);
    }

    /**
     * @return LoginManagerInterface
     */
    public function getDefaultLoginManager()
    {
        $defaultLoginManagerConfig = $this->loginManagerConfig[$this->config['defaultLoginManager']];

        $className = $defaultLoginManagerConfig['class'];
        $settings = $defaultLoginManagerConfig['settings'];

        return new $className($settings);
    }
}
