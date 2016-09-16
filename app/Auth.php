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

    public function doLogin(LoginManagerInterface $loginManager, $parsedBody)
    {
        $loginManager->login($parsedBody['account_id'], $parsedBody['password']);
        return 'redirect: ' . Application::getUrl();
    }

    public function doLogout(LoginManagerInterface $loginManager)
    {
        $loginManager->logout();
        return 'redirect: ' . Application::getUrl();
    }
}
