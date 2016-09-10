<?php

namespace Core\View;

use PHPUnit\Framework\TestCase;
use App\ViewResolver\DummyResolver;
use App\ViewEngine\DummyView;

class DummyResolverTest extends TestCase
{
    public function testDummyResolve()
    {
        $resolver = new DummyResolver();
        $resolver->setViewEngineConfig([]);

        $this->assertEquals(DummyView::class, get_class($resolver->resolve(null)));
        $this->assertEquals(null, $resolver->resolve('test'));
        $this->assertEquals(null, $resolver->resolve(''));
        $this->assertEquals(null, $resolver->resolve(1));
        $this->assertEquals(null, $resolver->resolve(0));
        $this->assertEquals(null, $resolver->resolve(false));
        $this->assertEquals(null, $resolver->resolve(true));
        $this->assertEquals(null, $resolver->resolve([]));
        $this->assertEquals(null, $resolver->resolve(new \stdClass));
    }
}
