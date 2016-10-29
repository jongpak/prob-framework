<?php

namespace App\Auth\LoginManager\Test;

use App\Auth\AuthManager;
use App\Auth\LoginManagerInterface;
use App\Auth\AccountManagerInterface;
use App\Auth\Exception\AccountNotFound;

class DummyLoginManager implements LoginManagerInterface
{
    /**
     * @var AccountManagerInterface
     */
    private $accountManager;

    public function __construct(array $settings = [])
    {
    }

    public function login($accountId, $password)
    {
    }

    public function logout()
    {
    }

    public function isLogged()
    {
    }

    public function getLoggedAccountId()
    {
    }
}
