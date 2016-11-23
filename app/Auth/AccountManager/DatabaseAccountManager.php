<?php

namespace App\Auth\AccountManager;

use App\Auth\AccountManagerInterface;
use App\Auth\HashManager;
use App\Entity\User;
use Core\Utils\EntityUtils\EntitySelect;

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

        return HashManager::getProvider()->isEqualValueAndHash($password, $this->getUserEntity($accountId)->getPassword());
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
        return EntitySelect::select(User::class)
            ->criteria(['accountId' => $accountId])
            ->findOne();
    }
}
