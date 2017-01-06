<?php

namespace App\Auth\AccountManager\Test;

use App\Auth\AccountManagerInterface;
use App\Auth\Model\Account;

class DummyAccountManager implements AccountManagerInterface
{
    public function __construct(array $settings = [])
    {
    }

    public function isExistAccountId($accountId)
    {
    }

    public function isEqualPassword($accountId, $password)
    {
    }

    /**
     * @param string $accountId
     * @return Account|null
     */
    public function getAccountById($accountId)
    {
    }

    public function getRole($accountId)
    {
    }
}
