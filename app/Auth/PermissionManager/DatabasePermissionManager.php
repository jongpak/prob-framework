<?php

namespace App\Auth\PermissionManager;

use App\Auth\PermissionManagerAbstract;
use App\Entity\Permission;
use App\Entity\Role;
use Core\Utils\ArrayUtils;
use Core\Utils\EntityUtils\EntitySelect;
use Doctrine\Common\Collections\Collection;

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
        $allPermission = $this->getAllPermission() ?: [];
        $operationKey = ArrayUtils::find($allPermission, $operation);

        if($operationKey === false) {
            return null;
        }

        return $allPermission[$operationKey];
    }

    private function getAllPermission()
    {
        $permissionRole = [];
        $permissions = EntitySelect::select(Permission::class)->findAll();

        if ($permissions === null) {
            return null;
        }

        /** @var Permission $permission */
        foreach ($permissions as $permission) {
            $permissionRole[$permission->getOperation()] = $this->getRoles($permission->getRoles());
        }

        return $permissionRole;
    }

    private function getRoles(Collection $roleCollection)
    {
        $roles = [];

        /** @var Role $role */
        foreach ($roleCollection as $role) {
            $roles[] = $role->getName();
        }

        return $roles;
    }
}
