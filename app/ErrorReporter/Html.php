<?php

namespace App\ErrorReporter;

use Core\ViewEngineInterface;
use Core\ErrorReporterInterface;

class Html implements ErrorReporterInterface
{
    private $settings = [];

    public function __construct($settings = [])
    {
        $this->settings = $settings;
    }

    /*
        $exception is not Exception type.
        because $exception can be Throwable type in PHP 7
     */
    public function report($exception)
    {
        $view = $this->constructViewInstance();
        $view->file($this->settings['file']);
        $this->setReportVariables($view, $exception);

        echo $view->render();
    }

    /**
     * @return ViewEngineInterface
     */
    private function constructViewInstance()
    {
        $viewClassName = $this->settings['view'];
        $view = new $viewClassName($this->settings);

        return $view;
    }

    private function setReportVariables(ViewEngineInterface $view, $exception)
    {
        $view->set('message', $exception->getMessage());
        $view->set('file', $exception->getFile());
        $view->set('line', $exception->getLine());
        $view->set('traces', $exception->getTrace());
    }
}
