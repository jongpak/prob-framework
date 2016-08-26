<?php

namespace Core;

use PHPUnit\Framework\TestCase;
use App\ViewEngine\Json;

class JsonViewTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testJsonViewByArray()
    {
        $array = [
            'test',
            false,
            123,
            ['ok']
        ];

        $viewResolver = new ViewResolver($array);
        $view = $viewResolver->resolve(['engine' => 'mock']);

        $this->assertEquals([], $view->getVariables());
        $this->assertEquals($array, $view->getFile());
        $this->expectOutputString(json_encode($array));
        $view->render();
    }

    /**
     * @runInSeparateProcess
     */
    public function testJsonViewByObject()
    {
        $object = new \stdClass();
        $object->var1 = 'test';
        $object->var2 = ['ok'];

        $viewResolver = new ViewResolver($object);
        $view = $viewResolver->resolve(['engine' => 'mock']);

        $this->assertEquals([], $view->getVariables());
        $this->assertEquals($object, $view->getFile());
        $this->expectOutputString(json_encode($object));
        $view->render();
    }
}
