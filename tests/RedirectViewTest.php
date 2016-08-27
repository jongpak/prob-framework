<?php

namespace Core;

use PHPUnit\Framework\TestCase;
use App\ViewEngine\Redirect;

class RedirectViewTest extends TestCase
{
    public function testRedirectView()
    {
        $url = 'test/url';

        $viewResolver = new ViewResolver('redirect: ' . $url);
        $view = $viewResolver->resolve(['class' => null]);

        $this->assertEquals([], $view->getVariables());
        $this->assertEquals($url, $view->getFile());
    }
}
