<?php

namespace App\Auth;

abstract class PermissionManagerAbstract
{
    abstract public function __construct(array $settings = []);

    /**
     * @return array|null
     */
    abstract public function getRolesByOperation($operation);

    /**
     * @return bool
     */
    public function hasAllowedRole($accountId, $operation)
    {
        $operationAllowedRoles = $this->getRolesByOperation($operation);
        $accountRoles = AuthManager::getAccountManager()->getRole($accountId) ?: [];

        if ($operationAllowedRoles === null) {
            return AuthManager::isDefaultAllow();
        }

        foreach ($accountRoles as $role) {
            if (in_array($role, $operationAllowedRoles) === true) {
                return true;
            }
        }

        return false;
    }
}
