<?php

namespace Core;

use \Exception;

interface ErrorReporterInterface
{
    public function __construct($settings = []);

    /**
     * @param  Exception|Error|Throwable $exception
     */
    public function report($exception);
}
