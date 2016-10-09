<?php

namespace App\ViewResolver;

use Core\View\ViewResolverInterface;
use App\ViewEngine\TwigView;

class TwigResolver implements ViewResolverInterface
{
    protected $settings = [];

    public function setViewEngineConfig(array $settings)
    {
        $this->settings = $settings;
    }

    public function resolve($viewData)
    {
        if (is_string($viewData)) {
            $view = new TwigView($this->settings);
            $view->file($viewData);

            return $view;
        }
    }
}
