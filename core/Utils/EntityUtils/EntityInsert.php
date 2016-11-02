<?php

namespace Core\Utils\EntityUtils;

use Core\DatabaseManager;

class EntityInsert
{
    public static function insert($entity)
    {
        DatabaseManager::getEntityManager()->persist($entity);
        DatabaseManager::getEntityManager()->flush();
    }
}