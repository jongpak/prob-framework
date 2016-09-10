<?php

namespace Core\View;

use PHPUnit\Framework\TestCase;
use App\ViewResolver\RedirectResolver;
use App\ViewEngine\RedirectView;

class RedirectResolverTest extends TestCase
{
    public function testJsonResolve()
    {
        $resolver = new RedirectResolver();
        $resolver->setViewEngineConfig([]);

        $this->assertEquals(RedirectView::class, get_class($resolver->resolve('redirect: url')));

        // [Issue #23] pattern => /^redirect:(.*)/
        $this->assertEquals(null, $resolver->resolve('???redirect: url'));

        $this->assertEquals(null, $resolver->resolve('test'));
        $this->assertEquals(null, $resolver->resolve(''));
        $this->assertEquals(null, $resolver->resolve(1));
        $this->assertEquals(null, $resolver->resolve(0));
        $this->assertEquals(null, $resolver->resolve(false));
        $this->assertEquals(null, $resolver->resolve(true));
        $this->assertEquals(null, $resolver->resolve([]));
        $this->assertEquals(null, $resolver->resolve(new \stdClass()));
    }
}
