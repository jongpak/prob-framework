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

    public function doLogin(ServerRequestInterface $request)
    {
        AuthManager::getLoginManager()->login($request->getParsedBody()['account_id'], $request->getParsedBody()['password']);
        return 'redirect: ' . Application::getInstance()->url();
    }

    public function doLogout()
    {
        AuthManager::getLoginManager()->logout();
        return 'redirect: ' . Application::getInstance()->url();
    }
}
