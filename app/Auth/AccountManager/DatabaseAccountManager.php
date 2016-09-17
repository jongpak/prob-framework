<?php

namespace App\Auth\AccountManager;

use App\Auth\AccountManagerInterface;
use App\Entity\User;
use Core\DatabaseManager;

class DatabaseAccountManager implements AccountManagerInterface
{
    public function __construct($settings = [])
    {
    }

    public function isExistAccountId($accountId)
    {
        return DatabaseManager::getEntityManager()
                ->getRepository(User::class)
                ->findOneBy(['accountId' => $accountId]) !== null;
    }

    public function isEqualPassword($accountId, $password)
    {
        if ($this->isExistAccountId($accountId) === false) {
            return false;
        }

        return DatabaseManager::getEntityManager()
                ->getRepository(User::class)
                ->findOneBy(['accountId' => $accountId])
                ->getPassword() === $password;
    }

    public function getRole($accountId)
    {
        if ($this->isExistAccountId($accountId) === false) {
            return null;
        }

        $roles = DatabaseManager::getEntityManager()
                    ->getRepository(User::class)
                    ->findOneBy(['accountId' => $accountId])
                    ->getRoles();

        $roleArray = [];

        foreach ($roles as $item) {
            $roleArray[] = $item->getName();
        }

        return $roleArray;
    }
}
