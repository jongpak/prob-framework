<?php

namespace Core\View;

use PHPUnit\Framework\TestCase;
use App\ViewResolver\TwigResolver;
use App\ViewEngine\TwigView;

class TwigResolverTest extends TestCase
{
    public function testJsonResolve()
    {
        $resolver = new TwigResolver();
        $resolver->setViewEngineConfig([
            'path' => '',
            'postfix' => '.twig',
            'settings' => []
        ]);

        $this->assertEquals(TwigView::class, get_class($resolver->resolve('dir/fileName')));
        $this->assertEquals(TwigView::class, get_class($resolver->resolve('fileName')));
        $this->assertEquals(TwigView::class, get_class($resolver->resolve('')));
        $this->assertEquals(null, $resolver->resolve(1));
        $this->assertEquals(null, $resolver->resolve(0));
        $this->assertEquals(null, $resolver->resolve(false));
        $this->assertEquals(null, $resolver->resolve(true));
        $this->assertEquals(null, $resolver->resolve([]));
        $this->assertEquals(null, $resolver->resolve(new \stdClass()));
    }
}
