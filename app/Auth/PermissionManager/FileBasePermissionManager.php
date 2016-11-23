<?php

namespace App\Auth\PermissionManager;

use App\Auth\PermissionManagerAbstract;
use Core\Utils\ArrayUtils;

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
        $operationKey = ArrayUtils::find($this->permission, $operation);

        if($operationKey === false) {
            return null;
        }

        return $this->permission[$operationKey];
    }
}
