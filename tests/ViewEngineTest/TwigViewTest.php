<?php

namespace Core;

use PHPUnit\Framework\TestCase;
use App\ViewEngine\Twig;

class TwigViewTest extends TestCase
{
    public function getTwigSetting()
    {
        return [
            'class' => 'App\\ViewEngine\\Twig',
            'path' => __DIR__ . '/mock',
            'postfix' => '.twig',
            'settings' => []
        ];
    }

    public function testStringView()
    {
        $view = new Twig($this->getTwigSetting());
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
            'url' => 'http://test.com/',
            'viewEngine' => 'Twig',
        ]);

        $view = new Twig($this->getTwigSetting());
        $view->file('testCustomFunction');

        $this->expectOutputString(
            "<link rel=\"stylesheet\" type=\"text/css\" href=\"css_test\">\n" .
            "http://test.com/public/asset_test\n" .
            "http://test.com/url_test"
        );
        $view->render();
    }
}
