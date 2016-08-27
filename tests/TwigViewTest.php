<?php

namespace Core;

use PHPUnit\Framework\TestCase;
use App\ViewEngine\Twig;

class TwigViewTest extends TestCase
{
    public function testStringView()
    {
        $viewResolver = new ViewResolver('test');
        $view = $viewResolver->resolve([
            'class' => 'Twig',
            'path' => __DIR__ . '/mock',
            'postfix' => '.twig',
            'settings' => []
        ]);

        $view->set('key', 'ok');

        $this->assertEquals(['key' => 'ok'], $view->getVariables());
        $this->assertEquals('test.twig', $view->getFile());
        $this->expectOutputString('ok');
        $view->render();
    }
}
