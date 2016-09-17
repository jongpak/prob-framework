<?php

namespace App\Auth\PermissionManager;

use App\Auth\PermissionManager;

class FileBasePermissionManager extends PermissionManager
{
    private $permission;

    public function __construct($settings = [])
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
