<?php

namespace App\EventListener\Auth;

use Prob\Handler\ProcInterface;
use App\Auth\AuthManager;
use App\Auth\LoginManagerInterface;
use App\EventListener\Auth\Exception\PermissionDenied;

class ValidatorListener
{
    public function validate(ProcInterface $proc, LoginManagerInterface $loginManager)
    {
        if ($this->isAllowedAccount($proc, $loginManager->getLoggedAccountId()) === false) {
            throw new PermissionDenied('This operation is not allowed');
        }

        return true;
    }

    public function isAllowedAccount(ProcInterface $proc, $accountId)
    {
        $allowdPermissionRoles = AuthManager::getPermissionManager()->getRolesByAction($proc->getName());
        $accountRoles = AuthManager::getAccountManager()->getRole($accountId) ?: [];

        if ($allowdPermissionRoles === null) {
            return AuthManager::isDefaultAllow();
        }

        foreach ($accountRoles as $role) {
            if (in_array($role, $allowdPermissionRoles)) {
                return true;
            }
        }

        return false;
    }
}
