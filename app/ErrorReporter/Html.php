<?php

namespace App\ErrorReporter;

use Core\ErrorReporter\ErrorReporterService;
use Core\View\ViewEngineInterface;
use Core\ErrorReporter\ErrorReporterInterface;

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

        return $view->render();
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

        $className = get_class($exception);
        $view->set('errorName', $className);
        $view->set('errorNameWithoutNamespace', substr($className, strrpos($className, '\\') ? strrpos($className, '\\') + 1 : 0));

        $view->set('displayExceptionInfo', $this->settings['displayExceptionInfo']);
        $view->set('displayFileInfo', $this->settings['displayFileInfo']);
        $view->set('displayErrorSourceLines', $this->settings['displayErrorSourceLines']);
        $view->set('errorSourceLines', ErrorReporterService::getErrorCodeLine($exception));
        $view->set('displayStackTrace', $this->settings['displayStackTrace']);
    }
}
