<?php

namespace App\ViewResolver;

use Core\ViewResolverInterface;
use App\ViewEngine\Twig;

class TwigResolver implements ViewResolverInterface
{
    private $settings = [];

    public function setViewEngineConfig(array $settings)
    {
        $this->settings = $settings;
    }

    public function resolve($viewData)
    {
        if (is_string($viewData)) {
            $view = new Twig($this->settings);
            $view->file($viewData);

            return $view;
        }
    }
}
