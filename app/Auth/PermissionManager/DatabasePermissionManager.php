<?php

namespace App\Auth\PermissionManager;

use App\Auth\PermissionManager;
use App\Entity\Permission;
use Core\Utils\EntityFinder;

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
        $permissionRole = [];

        /** @var Permission */
        $permission = EntityFinder::findOneBy(Permission::class, ['operation' => $operation]);

        if ($permission === null) {
            return null;
        }

        foreach ($permission->getRoles() as $item) {
            $permissionRole[] = $item->getName();
        }

        return $permissionRole;
    }
}
