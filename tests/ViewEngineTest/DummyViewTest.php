<?php

namespace Core;

use PHPUnit\Framework\TestCase;
use App\ViewEngine\DummyView;

class DummyViewTest extends TestCase
{
    public function testDummyView()
    {
        $view = new DummyView();
        $view->file('test');
        $view->set('one', 1);
        $view->set('two', 2);

        $this->assertEquals([], $view->getVariables());
        $this->assertEquals(null, $view->getFile());
        $this->expectOutputString(null);
        $this->assertEquals(null, $view->render());
    }
}
