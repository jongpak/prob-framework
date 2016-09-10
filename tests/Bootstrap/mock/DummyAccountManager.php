<?php

namespace App\Auth\AccountManager\Test;

use App\Auth\AccountManagerInterface;

class DummyAccountManager implements AccountManagerInterface
{
    public function __construct($settings = [])
    {
    }

    public function isExistAccountId($accountId)
    {
    }

    public function isEqualPassword($accountId, $password)
    {
    }

    public function getRole($accountId)
    {
    }
}
