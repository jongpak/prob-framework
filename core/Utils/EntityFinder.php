<?php

namespace Core\Utils;

use Core\DatabaseManager;

class EntityFinder
{
    public static function findById($entityName, $id)
    {
        return DatabaseManager::getEntityManager()->getRepository($entityName)->find($id);
    }

    public static function findOneBy($entityName, $criteria, $orderBy = [])
    {
        return DatabaseManager::getEntityManager()->getRepository($entityName)->findOneBy($criteria, $orderBy);
    }

    public static function findAll($entityName)
    {
        return DatabaseManager::getEntityManager()->getRepository($entityName)->findAll();
    }
}
