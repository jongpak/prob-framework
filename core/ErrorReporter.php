<?php

namespace Core;

use \Exception;

interface ErrorReporter
{
    public function init($setting = []);
    public function report(Exception $exception);
}
