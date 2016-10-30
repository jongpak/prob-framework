<?php

namespace App\Auth\PermissionManager;

use App\Auth\PermissionManagerAbstract;

class FileBasePermissionManager extends PermissionManagerAbstract
{
    private $permission;

    public function __construct(array $settings = [])
    {
        $this->permission = $settings['permissions'];
    }

    /**
     * @return array|null
     */
    public function getRolesByOperation($operation)
    {
        return isset($this->permission[$operation]) ? $this->permission[$operation] : null;
    }
}
