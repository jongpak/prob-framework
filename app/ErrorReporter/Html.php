<?php

namespace App\ErrorReporter;

use Core\ErrorReporter;
use \Exception;

class Html implements ErrorReporter
{
    /**
         * @var View
         */
    private $view;

    public function init($setting = [])
    {
        $this->buildView($setting);
    }

    private function buildView($setting)
    {
        $this->view = new $setting['view'];
        $this->view->init($setting);
        $this->view->file($setting['file']);
    }

    public function report(Exception $exception)
    {
        $this->setReportVariables($exception);
        echo $this->view->render();
    }

    private function setReportVariables(Exception $exception)
    {
        $this->view->set('message', $exception->getMessage());
        $this->view->set('file', $exception->getFile());
        $this->view->set('line', $exception->getLine());
        $this->view->set('traces', $exception->getTrace());
    }
}
