<?php

namespace App\ViewResolver;

use Core\ViewResolverInterface;
use App\ViewEngine\Json;

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
            $view = new Json($this->settings);
            $view->file($viewData);

            return $view;
        }
    }
}
