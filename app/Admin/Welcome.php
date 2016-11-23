<?php

namespace App\Controller\Admin;

use Core\ViewModel;

class Welcome {
    public function index(ViewModel $view) {
        $view->set('absolutePath', realpath(__DIR__ . '/../../'));
        $view->set('phpVersion', PHP_VERSION);
        $view->set('os', PHP_OS);
        $view->set('sapi', PHP_SAPI);

        return 'welcome';
    }
}