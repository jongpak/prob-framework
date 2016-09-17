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
        if (AuthManager::getPermissionManager()
                ->hasAllowedRole($loginManager->getLoggedAccountId(), $proc->getName()) === false
        ) {
            throw new PermissionDenied('This operation is not allowed');
        }

        return true;
    }
}
