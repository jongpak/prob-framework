<?php

namespace App\Controller;

use Core\ViewModel;
use App\Auth\AuthManager;

class Welcome
{
    public function index(ViewModel $viewModel)
    {
        $accountManager = AuthManager::getAccountManager();
        $loginManager = AuthManager::getLoginManager();

        $loggedAccountId = $loginManager->getLoggedAccountId();

        $viewModel->set('time', date('r'));
        $viewModel->set('accountId', $loggedAccountId);
        $viewModel->set('accountRole', $accountManager->getRole($loggedAccountId));

        return 'default/welcome';
    }
}
