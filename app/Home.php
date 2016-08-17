<?php

namespace App\Controller;

use Core\ViewModel;

class Home
{

    public function index(ViewModel $viewModel)
    {
        $viewModel->set('time', date('r'));
        return 'default/main';
    }
}
