<?php

namespace App\ErrorReporter;

use PHPUnit\Framework\TestCase;
use \ErrorException;

class HtmlErrorReporterTest extends TestCase
{
    public function getReporterSetting()
    {
        return [
            'class' => 'App\\ErrorReporter\\Html',
            'view' => 'App\\ViewEngine\\TwigView',
            'path' => __DIR__ . '/../mock',
            'file' => 'error',
            'postfix' => '.twig',
            'displayExceptionInfo' => true,
            'displayFileInfo' => true,
            'displayStackTrace' => true,
            'displayErrorSourceLines' => true,
            'settings' => []
        ];
    }

    public function testHtmlReport()
    {
        $reporter = new Html($this->getReporterSetting());
        $exception = new ErrorException('message', 0, E_ERROR, __FILE__, 10);

        $this->assertEquals("message\n" . __FILE__ . "\n10", $reporter->report($exception));
    }
}
