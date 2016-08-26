<?php

namespace Core;

use PHPUnit\Framework\TestCase;
use App\ViewEngine\StringViewForTest;
use App\ViewEngine\Json;
use App\ViewEngine\Redirect;
use App\ViewEngine\DummyView;

class ViewResolverTest extends TestCase
{
    public function testStringResolve()
    {
        include_once 'mock/StringViewForTest.php';

        $viewResolver = new ViewResolver('default/test');
        $view = $viewResolver->resolve(['engine' => 'StringViewForTest']);
        $this->assertEquals(StringViewForTest::class, get_class($view));
    }

    /**
     * @runInSeparateProcess
     */
    public function testJsonResolveByArray()
    {
        $array = [
            'test',
            false,
            123,
            ['ok']
        ];

        $viewResolver = new ViewResolver($array);
        $view = $viewResolver->resolve(['engine' => 'StringViewForTest']);

        $this->assertEquals(Json::class, get_class($view));
    }

    /**
     * @runInSeparateProcess
     */
    public function testJsonResolveByObject()
    {
        $object = new \stdClass();

        $viewResolver = new ViewResolver($object);
        $view = $viewResolver->resolve(['engine' => 'StringViewForTest']);

        $this->assertEquals(Json::class, get_class($view));
    }

    public function testDummyResolve()
    {
        $viewResolver = new ViewResolver(null);
        $view = $viewResolver->resolve(['engine' => 'StringViewForTest']);

        $this->assertEquals(DummyView::class, get_class($view));
    }

    public function testRedirectResolve()
    {
        $viewResolver = new ViewResolver('redirect: test/url');
        $view = $viewResolver->resolve(['engine' => 'StringViewForTest']);

        $this->assertEquals(Redirect::class, get_class($view));
    }
}
