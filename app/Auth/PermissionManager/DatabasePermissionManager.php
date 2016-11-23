<?php

namespace App\Auth\PermissionManager;

use App\Auth\PermissionManagerAbstract;
use App\Entity\Permission;
use App\Entity\Role;
use Core\Utils\EntityUtils\EntitySelect;

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

        /** @var Permission $permission */
        $permission = EntitySelect::select(Permission::class)
            ->criteria(['operation' => $operation])
            ->findOne();

        if ($permission === null) {
            return null;
        }

        /** @var Role $item */
        foreach ($permission->getRoles() as $item) {
            $permissionRole[] = $item->getName();
        }

        return $permissionRole;
    }
}
