<?php

namespace Core;

use PHPUnit\Framework\TestCase;
use App\ViewEngine\StringViewForTest;
use App\ViewEngine\Json;
use App\ViewEngine\DummyView;

class ViewResolverTest extends TestCase
{
    public function testStringResolve()
    {
        $viewResolver = new ViewResolver('default/test');
        $view = $viewResolver->resolve(['engine' => 'StringViewForTest']);
        $view->set('key', 'ok');

        $this->assertEquals(StringViewForTest::class, get_class($view));
        $this->expectOutputString('ok');
        $view->render();
    }

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
        $this->expectOutputString(json_encode($array));
        $view->render();
    }

    public function testJsonResolveByObject()
    {
        $object = new DumpObject();

        $viewResolver = new ViewResolver($object);
        $view = $viewResolver->resolve(['engine' => 'StringViewForTest']);

        $this->assertEquals(Json::class, get_class($view));
        $this->expectOutputString(json_encode($object));
        $view->render();
    }

    public function testDummyResolve()
    {
        $viewResolver = new ViewResolver(null);
        $view = $viewResolver->resolve(['engine' => 'StringViewForTest']);

        $this->assertEquals(DummyView::class, get_class($view));
        $this->expectOutputString(null);
        $view->render();
    }
}

class DumpObject
{

    public $var1 = 'test';
    public $var2 = [
        'ok'
    ];
}


namespace App\ViewEngine;

use Core\View;

class StringViewForTest implements View
{

    /**
     * template file
     *
     * @var string
     */
    private $templateFilename = '';

    /**
     * @var array engine setting
     */
    private $settings = [];

    /**
     * rendering template variables
     * @var array
     */
    private $var = [];

    public function init($settings = [])
    {
        $this->settings = $settings;
    }

    public function set($key, $value)
    {
        $this->var[$key] = $value;
    }

    public function file($fileName)
    {
        $this->templateFilename = $fileName;
    }

    public function render()
    {
        echo $this->var['key'];
    }
}