<?php

namespace App\ErrorReporter;

use Core\ViewEngineInterface;
use Core\ErrorReporterInterface;
use \Exception;

class Html implements ErrorReporterInterface
{
    private $settings = [];

    public function __construct($settings = [])
    {
        $this->settings = $settings;
    }

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

    private function setReportVariables(ViewEngineInterface $view, Exception $exception)
    {
        $view->set('message', $exception->getMessage());
        $view->set('file', $exception->getFile());
        $view->set('line', $exception->getLine());
        $view->set('traces', $exception->getTrace());
    }
}
