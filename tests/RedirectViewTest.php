<?php

namespace Core;

use PHPUnit\Framework\TestCase;
use App\ViewEngine\Redirect;

class RedirectViewTest extends TestCase
{
    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testRedirectView()
    {
        $url = 'test/url';

        $viewResolver = new ViewResolver('redirect: ' . $url);
        $view = $viewResolver->resolve(['class' => null]);
        $view->set('one', 1);
        $view->set('two', 2);

        $this->assertEquals([], $view->getVariables());
        $this->assertEquals($url, $view->getFile());
        $view->render();
    }
}
