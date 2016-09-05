<?php

namespace App\EventListener\Auth;

use App\Auth\AuthManager;
use App\Auth\LoginManagerInterface;
use App\Auth\AccountManagerInterface;
use Prob\Rewrite\Request;
use Prob\Handler\ProcInterface;
use App\EventListener\Auth\Exception\PermissionDenied;

class Validator
{
    /**
     * @var AccountManagerInterface
     */
    private $accountManager;

    /**
     * @var LoginManagerInterface
     */
    private $loginManager;

    private $controllerPermission = [];

    /**
     * @var ProcInterface
     */
    private $controller;

    public function __construct(array $controllerPermission)
    {
        $this->accountManager = AuthManager::getInstance()->getDefaultAccountManager();
        $this->loginManager = AuthManager::getInstance()->getDefaultLoginManager();

        $this->controllerPermission = $controllerPermission;
    }

    public function validate(ProcInterface $controller)
    {
        $this->controller = $controller;

        if ($this->isAllowPermission() === false) {
            throw new PermissionDenied('This operation is not allowed');
        }

        return true;
    }

    private function isAllowPermission()
    {
        if ($this->isExistControllerPermissionConfig() === false) {
            return AuthManager::getInstance()->isDefaultAllow();
        }

        return $this->isAllowRole();
    }

    private function isExistControllerPermissionConfig()
    {
        return isset($this->controllerPermission[$this->controller->getName()]);
    }

    private function isAllowRole()
    {
        if (isset($this->controllerPermission[$this->controller->getName()]['role']) === false) {
            return false;
        }

        $accountRoles = $this->accountManager->getRole($this->loginManager->getLoggedAccountId()) ?: [];
        $allowRoles = $this->controllerPermission[$this->controller->getName()]['role'];

        foreach ($accountRoles as $role) {
            if (in_array($role, $allowRoles) === true) {
                return true;
            }
        }

        return false;
    }
}
