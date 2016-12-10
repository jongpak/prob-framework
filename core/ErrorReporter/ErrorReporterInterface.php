<?php

namespace Core\ErrorReporter;

use Error;
use Exception;
use Throwable;

interface ErrorReporterInterface
{
    public function __construct($settings = []);

    /**
     * @param  Exception|Error|Throwable $exception
     */
    public function report($exception);
}
