<?php

namespace Core\View;

use PHPUnit\Framework\TestCase;
use App\ViewResolver\JsonResolver;
use App\ViewEngine\JsonView;

class JsonResolverTest extends TestCase
{
    public function testJsonResolve()
    {
        $resolver = new JsonResolver();
        $resolver->setViewEngineConfig([]);

        $this->assertEquals(JsonView::class, get_class($resolver->resolve([])));
        $this->assertEquals(JsonView::class, get_class($resolver->resolve(new \stdClass)));
        $this->assertEquals(null, $resolver->resolve('test'));
        $this->assertEquals(null, $resolver->resolve(''));
        $this->assertEquals(null, $resolver->resolve(1));
        $this->assertEquals(null, $resolver->resolve(0));
        $this->assertEquals(null, $resolver->resolve(false));
        $this->assertEquals(null, $resolver->resolve(true));
    }
}
