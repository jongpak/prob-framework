<?php

namespace App\ViewResolver;

use Core\View\ViewResolverInterface;
use App\ViewEngine\RedirectView;

class RedirectResolver implements ViewResolverInterface
{
    private $settings = [];

    public function setViewEngineConfig(array $settings)
    {
        $this->settings = $settings;
    }

    public function resolve($viewData)
    {
        if (is_string($viewData) === false) {
            return;
        }

        if (preg_match('/^redirect:(.*)/', $viewData, $url) === 0) {
            return;
        }

        $view = new RedirectView($this->settings);
        $view->file(trim($url[1]));

        return $view;
    }
}
