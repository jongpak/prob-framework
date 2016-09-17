<?php

namespace App\Auth;

use Prob\Handler\ProcInterface;

abstract class PermissionManager
{
    abstract public function __construct($settings = []);

    /**
     * @return array|null
     */
    abstract public function getRolesByAction($action);

    /**
     * @return bool
     */
    public function hasAllowedRole($accountId, $action)
    {
        $actionAllowedRoles = $this->getPermissionItemByAction($action);
        $accountRoles = AuthManager::getAccountManager()->getRole($accountId) ?: [];

        if ($actionAllowedRoles === null) {
            return AuthManager::isDefaultAllow();
        }

        foreach ($accountRoles as $role) {
            if (in_array($role, $actionAllowedRoles) === true) {
                return true;
            }
        }

        return false;
    }
}
