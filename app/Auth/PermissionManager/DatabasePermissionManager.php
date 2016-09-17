<?php

namespace App\Auth\PermissionManager;

use App\Auth\PermissionManager;
use App\Entity\Permission;
use Core\DatabaseManager;

class DatabasePermissionManager extends PermissionManager
{
    public function __construct($settings = [])
    {
    }

    /**
     * @return array|null
     */
    public function getRolesByOperation($operation)
    {
        $roleArray = [];

        /** @var Permission */
        $permission = DatabaseManager::getEntityManager()
                        ->getRepository(Permission::class)
                        ->findOneBy(['operation' => $operation]);

        if ($permission === null) {
            return null;
        }

        foreach ($permission->getRoles() as $item) {
            $roleArray[] = $item->getName();
        }

        return $roleArray;
    }
}
