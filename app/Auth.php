<?php

namespace App\Controller;

use Core\Application;
use App\Auth\AuthManager;
use App\Auth\LoginManagerInterface;
use App\Auth\AccountManagerInterface;
use Psr\Http\Message\ServerRequestInterface;

class Auth
{
    public function viewLoginForm()
    {
        return 'auth/login';
    }

    public function doLogin($parsedBody)
    {
        AuthManager::getLoginManager()->login($parsedBody['account_id'], $parsedBody['password']);
        return 'redirect: ' . Application::getUrl();
    }

    public function doLogout()
    {
        AuthManager::getLoginManager()->logout();
        return 'redirect: ' . Application::getUrl();
    }
}
