<?php

namespace Core;

use \ErrorException;
use Core\ErrorReporterInterface;

class ErrorReporterRegister
{
    private $config = [];
    private $errorReporterInstances = [];

    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    public function register()
    {
        $this->constructErrorReporters();
        $this->registerErrorReporters();
    }

    private function registerErrorReporters()
    {
        /**
         * @var ErrorReporter $reporter
         */
        set_exception_handler(function ($exception) {
            foreach ($this->errorReporterInstances as $reporter) {
                $reporter->report($exception);
            }
        });

        set_error_handler(function ($errno, $errstr, $errfile, $errline, array $errcontext) {
            throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
        });
    }

    private function constructErrorReporters()
    {
        $errorReporterInstances = [];

        foreach ($this->config['enableReporters'] as $reporterName) {
            $errorReporterInstances[] = $this->getErrorReporterInstance($reporterName);
        }

        $this->errorReporterInstances = $errorReporterInstances;
    }

    /**
     * @param  string $reporterName
     * @return ErrorReporterInterface
     */
    private function getErrorReporterInstance($reporterName)
    {
        $class = $this->config['reporters'][$reporterName]['class'];
        return new $class($this->config['reporters'][$reporterName]);
    }
}
