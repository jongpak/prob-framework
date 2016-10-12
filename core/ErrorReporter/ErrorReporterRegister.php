<?php

namespace Core\ErrorReporter;

use \ErrorException;
use App\ViewResolver\ResponseResolver;
use Zend\Diactoros\Response\EmptyResponse;

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
                $reportResult = $reporter->report($exception);

                $this->initHttpResponseHeader();

                echo $reportResult;
            }
        });

        set_error_handler(function ($errno, $errstr, $errfile, $errline, array $errcontext) {
            throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
        });
    }

    private function initHttpResponseHeader()
    {
        $responseResolver = new ResponseResolver();

        if ($responseResolver->getResponseProxyInstance()->getResponse() === null) {
            $responseResolver
                ->getResponseProxyInstance()
                ->setResponse(new EmptyResponse(500));
        }

        $responseResolver->resolve(null);
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
