<?php

namespace Core;

use \ErrorException;
use Core\ErrorReporterInterface;

class ErrorReporterRegister
{

    private $errorReporterConfig = [];
    private $enabledReporters = [];

    private $errorReporters = [];

    public function setErrorReporterConfig(array $errorReporterConfig)
    {
        $this->errorReporterConfig = $errorReporterConfig;
    }

    public function setEnabledReporters(array $reports)
    {
        $this->enabledReporters = $reports;
    }

    public function register()
    {
        $this->buildErrorReporters();
        $this->registerErrorReporters();
    }

    private function registerErrorReporters()
    {
        /**
         * @var ErrorReporter $reporter
         */
        set_exception_handler(function ($exception) {
            foreach ($this->errorReporters as $reporter) {
                $reporter->report($exception);
            }
        });

        set_error_handler(function ($errno, $errstr, $errfile, $errline, array $errcontext) {
            throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
        });
    }

    private function buildErrorReporters()
    {
        $errorReporters = [];

        foreach ($this->enabledReporters as $reporter) {
            $errorReporters[] = $this->getErrorReporterInstance($reporter);
        }

        $this->errorReporters = $errorReporters;
    }

    /**
     * @param  string $reporterName
     * @return ErrorReporterInterface
     */
    private function getErrorReporterInstance($reporterName)
    {
        $class = $this->errorReporterConfig[$reporterName]['class'];
        return new $class($this->errorReporterConfig[$reporterName]);
    }
}
