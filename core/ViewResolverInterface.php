<?php

namespace Core;

interface ViewResolverInterface
{
    public function setViewEngineConfig(array $settings);

    /**
     * @param  mixed $viewData
     * @return ViewEngineInterface
     */
    public function resolve($viewData);
}
