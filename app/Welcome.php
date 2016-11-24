<?php

namespace App\Controller;

use App\Auth\AccountManagerInterface;
use App\Auth\LoginManagerInterface;
use Core\ViewModel;

class Welcome
{
    public function index(
        AccountManagerInterface $accountManager,
        LoginManagerInterface $loginManager,
        ViewModel $viewModel)
    {
        $loggedAccountId = $loginManager->getLoggedAccountId();

        $viewModel->set('time', date('r'));
        $viewModel->set('accountId', $loggedAccountId);
        $viewModel->set('accountRole', $accountManager->getRole($loggedAccountId));

        return 'welcome';
    }
}
