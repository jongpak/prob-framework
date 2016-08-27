<?php

namespace Core;

use \Exception;

interface ErrorReporter
{
    public function init($setting = []);

    /**
     * @param  Exception|Error|Throwable $exception
     */
    public function report($exception);
}
