<?php

namespace Core\Utils\EntityUtils;

use Core\DatabaseManager;

class EntityDelete
{
    public static function insert($entity)
    {
        DatabaseManager::getEntityManager()->remove($entity);
        DatabaseManager::getEntityManager()->flush();
    }
}