<?php

namespace App\ViewResolver;

use Core\View\ViewResolverInterface;
use App\ViewEngine\JsonView;

class JsonResolver implements ViewResolverInterface
{
    private $settings = [];

    public function setViewEngineConfig(array $settings)
    {
        $this->settings = $settings;
    }

    public function resolve($viewData)
    {
        if (is_array($viewData) || is_object($viewData)) {
            $view = new JsonView($this->settings);
            $view->file($viewData);

            return $view;
        }
    }
}
