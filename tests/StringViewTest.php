<?php

namespace Core;

use PHPUnit\Framework\TestCase;
use App\ViewEngine\StringViewForTest;

class StringViewTest extends TestCase
{
    public function testStringView()
    {
        include_once 'mock/StringViewForViewTest.php';

        $viewResolver = new ViewResolver('default/test');
        $view = $viewResolver->resolve(['class' => 'StringViewForViewTest']);
        $view->set('key', 'ok');

        $this->assertEquals(['key' => 'ok'], $view->getVariables());
        $this->assertEquals('default/test', $view->getFile());
        $this->expectOutputString('ok');
        $view->render();
    }
}
