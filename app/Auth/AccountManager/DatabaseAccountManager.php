<?php

namespace App\Auth\AccountManager;

use App\Auth\AccountManagerInterface;
use App\Entity\User;
use Core\Utils\EntityFinder;

class DatabaseAccountManager implements AccountManagerInterface
{
    public function __construct(array $settings = [])
    {
    }

    public function isExistAccountId($accountId)
    {
        return $this->getUserEntity($accountId) !== null;
    }

    public function isEqualPassword($accountId, $password)
    {
        if ($this->isExistAccountId($accountId) === false) {
            return false;
        }

        return $this->getUserEntity($accountId)->getPassword() === $password;
    }

    public function getRole($accountId)
    {
        if ($this->isExistAccountId($accountId) === false) {
            return null;
        }

        $roles = $this->getUserEntity($accountId)->getRoles();
        $accountRole = [];

        foreach ($roles as $item) {
            $accountRole[] = $item->getName();
        }

        return $accountRole;
    }

    /**
     * @param  string $accountId
     * @return User
     */
    public function getUserEntity($accountId)
    {
        return EntityFinder::findOneBy(User::class, ['accountId' => $accountId]);
    }
}
