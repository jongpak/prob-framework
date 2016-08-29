<?php

namespace Core;

use \Exception;

interface ErrorReporterInterface
{
    public function init($setting = []);

    /**
     * @param  Exception|Error|Throwable $exception
     */
    public function report($exception);
}
