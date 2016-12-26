<?php

namespace Core\ControllerDispatcher;

use App\ViewEngine\DummyView;
use App\ViewEngine\JsonView;
use App\ViewEngine\RedirectView;
use App\ViewEngine\TwigView;
use App\ViewResolver\DummyResolver;
use App\ViewResolver\JsonResolver;
use App\ViewResolver\RedirectResolver;
use App\ViewResolver\ResponseResolver;
use App\ViewResolver\TwigResolver;
use Core\ViewModel;
use PHPUnit\Framework\TestCase;

class ViewRendererTest extends TestCase
{
    public function testResolve()
    {
        $resolver = new ViewRenderer();
        $resolver->setViewEngineConfig([
            'Twig' => [
                'path' => __DIR__ . '/../ViewEngineTest/mock',
                'postfix' => '.twig',
                'settings' => []
            ]
        ]);
        $resolver->setViewResolver([
            ResponseResolver::class,
            DummyResolver::class,
            RedirectResolver::class,
            'Twig' => TwigResolver::class,
            JsonResolver::class,
        ]);

        $this->assertEquals(DummyView::class, get_class($resolver->resolveView(null)));
        $this->assertEquals(RedirectView::class, get_class($resolver->resolveView('redirect:url')));
        $this->assertEquals(TwigView::class, get_class($resolver->resolveView('test')));
        $this->assertEquals(JsonView::class, get_class($resolver->resolveView([' test' ])));
    }

    public function testRender()
    {
        $resolver = new ViewRenderer();
        $resolver->setViewEngineConfig([
            'Twig' => [
                'path' => __DIR__ . '/../ViewEngineTest/mock',
                'postfix' => '.twig',
                'settings' => []
            ]
        ]);
        $resolver->setViewResolver([
            ResponseResolver::class,
            DummyResolver::class,
            RedirectResolver::class,
            'Twig' => TwigResolver::class,
            JsonResolver::class,
        ]);

        $viewModel = new ViewModel();
        $viewModel->set('key', 'value');

        $resolver->setViewModel($viewModel);

        $this->assertEquals('value', $resolver->renderView('test'));
    }
}
