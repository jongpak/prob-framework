<?php

namespace App\Auth\AccountManager;

use App\Auth\AccountManagerInterface;
use App\Auth\Model\Account;

class FileBaseAccountManager implements AccountManagerInterface
{
    private $accounts = [];

    public function __construct(array $settings = [])
    {
        $this->accounts = $settings['accounts'];
    }

    public function isExistAccountId($accountId)
    {
        return isset($this->accounts[$accountId]);
    }

    public function isEqualPassword($accountId, $password)
    {
        if ($this->isExistAccountId($accountId) === false) {
            return false;
        }

        return $this->accounts[$accountId]['password'] === $password;
    }

    /**
     * @param string $accountId
     * @return Account|null
     */
    public function getAccountById($accountId)
    {
        if(isset($this->accounts[$accountId]) === false) {
            return null;
        }

        $user = $this->accounts[$accountId];

        $account = new Account();
        $account->setAccountId($accountId);
        $account->setPassword($user['password']);
        $account->setName($user['name']);

        return $account;
    }

    public function getRole($accountId)
    {
        if ($this->isExistAccountId($accountId) === false) {
            return null;
        }

        return $this->accounts[$accountId]['role'];
    }
}
