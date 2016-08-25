<?php

namespace App\Controller;

use Core\ViewModel;

class Welcome
{

    public function index(ViewModel $viewModel)
    {
        $viewModel->set('time', date('r'));
        return 'default/welcome';
    }
}
