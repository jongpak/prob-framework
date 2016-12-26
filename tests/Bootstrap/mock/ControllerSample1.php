<?php

namespace App\Bootstrap\Test\Mock;

use Core\ViewModel;

class ControllerSample1
{
    public function index(ViewModel $viewModel) {
        $viewModel->set('key', 'index');
        return 'test';
    }

    public function hello() {
        echo 'hello!';
    }

    public function viewPrefix(ViewModel $viewModel) {
        $viewModel->set('key', 'test');
        return 'test';
    }
}