<?php

namespace Core;

class LazyWiringParameterCallback
{
    private $lazyBindingCallback;

    public function __construct(callable $lazyBindingCallback)
    {
        $this->lazyBindingCallback = $lazyBindingCallback;
    }

    public function exec()
    {
        return ($this->lazyBindingCallback)();
    }
}
