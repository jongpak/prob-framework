<?php

namespace App\ErrorReporter;

use App\Controller\Admin\AdminService;
use Core\ErrorReporter\ErrorReporterInterface;

class ConsoleStacktrace implements ErrorReporterInterface
{
    private $settings = [];

    public function __construct($settings = [])
    {
        $this->settings = $settings;
    }

    /**
     * @param \Error|\Exception|\Throwable $exception
     */
    public function report($exception)
    {
        printf('%s' . PHP_EOL, $exception->getMessage());
        printf(' => exception: %s' . PHP_EOL, get_class($exception));
        echo PHP_EOL;
        echo 'Stacktrace:' . PHP_EOL;

        foreach ($exception->getTrace() as $key => $value) {
            printf(' => [%d] %s:%d' . PHP_EOL, $key, $this->stripPublicPath($value['file']), $value['line']);
        }
    }

    private function stripPublicPath($path) {
        return str_replace(AdminService::getEnvironment('site')['publicPath'], '', $path);
    }
}
