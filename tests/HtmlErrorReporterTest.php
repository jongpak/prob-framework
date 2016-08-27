<?php

namespace Core;

use PHPUnit\Framework\TestCase;
use App\ErrorReporter\Html;
use \ErrorException;

class HtmlErrorReporterTest extends TestCase
{

    public function testHtmlReport()
    {
        $reporter = new Html();
        $reporter->init([
            'class' => 'Html',
            'view' => 'App\\ViewEngine\\Twig',
            'path' => __DIR__ . '/mock',
            'file' => 'error',
            'postfix' => '.twig',
            'settings' => []
        ]);

        $exception = new ErrorException('message', 0, E_ERROR, 'test.php', 56);

        $this->expectOutputString("message\ntest.php\n56");
        $reporter->report($exception);
    }
}
