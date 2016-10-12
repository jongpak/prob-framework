<?php

namespace Core;

use PHPUnit\Framework\TestCase;
use App\ViewEngine\JsonView;

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

        $view = new JsonView();
        $view->file($array);
        $view->set('one', 1);
        $view->set('two', 2);

        $this->assertEquals([], $view->getVariables());
        $this->assertEquals($array, $view->getFile());
        $this->assertEquals(json_encode($array), $view->render());
    }

    /**
     * @runInSeparateProcess
     */
    public function testJsonViewByObject()
    {
        $object = new \stdClass();
        $object->var1 = 'test';
        $object->var2 = ['ok'];

        $view = new JsonView();
        $view->file($object);
        $view->set('one', 1);
        $view->set('two', 2);

        $this->assertEquals([], $view->getVariables());
        $this->assertEquals($object, $view->getFile());
        $this->assertEquals(json_encode($object), $view->render());
    }
}
