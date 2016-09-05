<?php

namespace App\Controller;

use Core\Application;
use App\Auth\AuthManager;
use App\Auth\LoginManagerInterface;
use App\Auth\AccountManagerInterface;
use Psr\Http\Message\ServerRequestInterface;

class Auth
{
    /**
     * @var AccountManagerInterface
     */
    private $accountManager;

    /**
     * @var LoginManagerInterface
     */
    private $loginManager;

    public function __construct()
    {
        $this->accountManager = AuthManager::getInstance()->getDefaultAccountManager();
        $this->loginManager = AuthManager::getInstance()->getDefaultLoginManager();
    }

    public function viewLoginForm()
    {
        return 'auth/login';
    }

    public function doLogin(ServerRequestInterface $request)
    {
        $this->loginManager->login($request->getParsedBody()['account_id'], $request->getParsedBody()['password']);
        return 'redirect: ' . Application::getInstance()->url();
    }

    public function doLogout()
    {
        $this->loginManager->logout();
        return 'redirect: ' . Application::getInstance()->url();
    }
}
