<?php

namespace App\Auth\PermissionManager;

use App\Auth\PermissionManagerAbstract;
use App\Entity\Permission;
use Core\Utils\EntityFinder;

class DatabasePermissionManager extends PermissionManagerAbstract
{
    public function __construct(array $settings = [])
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
