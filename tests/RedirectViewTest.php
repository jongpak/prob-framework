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

        $view = new Redirect();
        $view->file($url);
        $view->set('one', 1);
        $view->set('two', 2);

        $this->assertEquals([], $view->getVariables());
        $this->assertEquals($url, $view->getFile());
        $view->render();
    }
}
