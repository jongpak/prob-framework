<?php

namespace Core;

use PHPUnit\Framework\TestCase;
use App\ViewEngine\DummyView;

class DummyViewTest extends TestCase
{
    public function testDummyView()
    {
        $viewResolver = new ViewResolver(null);
        $view = $viewResolver->resolve(['class' => null]);
        $view->set('one', 1);
        $view->set('two', 2);

        $this->assertEquals([], $view->getVariables());
        $this->assertEquals(null, $view->getFile());
        $this->expectOutputString(null);
        $view->render();
    }
}
