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
            'settings' => []
        ];
    }

    public function testHtmlReport()
    {
        $reporter = new Html($this->getReporterSetting());
        $exception = new ErrorException('message', 0, E_ERROR, 'test.php', 56);

        $this->assertEquals("message\ntest.php\n56", $reporter->report($exception));
    }
}
