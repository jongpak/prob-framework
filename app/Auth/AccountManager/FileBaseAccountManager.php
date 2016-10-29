<?php

namespace App\Auth\AccountManager;

use App\Auth\AccountManagerInterface;

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

    public function getRole($accountId)
    {
        if ($this->isExistAccountId($accountId) === false) {
            return null;
        }

        return $this->accounts[$accountId]['role'];
    }
}
