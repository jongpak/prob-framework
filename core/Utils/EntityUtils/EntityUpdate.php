<?php

namespace Core\Utils\EntityUtils;

use Core\DatabaseManager;

class EntityUpdate
{
    public static function update($entity)
    {
        DatabaseManager::getEntityManager()->flush();
    }
}