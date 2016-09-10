<?php

namespace Core;

use PHPUnit\Framework\TestCase;
use App\ViewEngine\TwigView;

class TwigViewTest extends TestCase
{
    public function getTwigSetting()
    {
        return [
            'path' => __DIR__ . '/mock',
            'postfix' => '.twig',
            'settings' => []
        ];
    }

    public function testStringView()
    {
        $view = new TwigView($this->getTwigSetting());
        $view->file('test');
        $view->set('key', 'ok');

        $this->assertEquals(['key' => 'ok'], $view->getVariables());
        $this->assertEquals('test.twig', $view->getFile());
        $this->expectOutputString('ok');
        $view->render();
    }

    public function testCustomFunctionTest()
    {
        $application = Application::getInstance();
        $application->setSiteConfig([
            'url' => '/',
            'publicPath' => '/public/',
        ]);

        $view = new TwigView($this->getTwigSetting());
        $view->file('testCustomFunction');

        $this->expectOutputString(
            "<link rel=\"stylesheet\" type=\"text/css\" href=\"css_test\">\n" .
            "/public/asset_test\n" .
            "/url_test"
        );
        $view->render();
    }
}
