<?php

namespace App\ViewResolver;

use Core\ViewResolverInterface;
use App\ViewEngine\DummyView;

class DummyResolver implements ViewResolverInterface
{
    private $settings = [];

    public function setViewEngineConfig(array $settings)
    {
        $this->settings = $settings;
    }

    public function resolve($viewData)
    {
        if ($viewData === null) {
            return new DummyView($this->settings);
        }
    }
}
