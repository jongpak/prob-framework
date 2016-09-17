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
    public function getRolesByAction($action)
    {
        return isset($this->permission[$action]) ? $this->permission[$action] : null;
    }
}
