<?php

namespace Core;

class ViewResolver
{
    /**
     * raw view data
     *
     * @var mixed
     */
    private $viewData;

    /**
     * ViewResolver constructor.
     *
     * @param string|object|array $data A view data by returned controller
     */
    public function __construct($data)
    {
        $this->viewData = $data;
    }

    /**
     * Resolve View
     *
     * @param array $settings View engine settings
     * @return View
     */
    public function resolve($settings)
    {
        $engineName = '\\App\\ViewEngine\\';

        switch (gettype($this->viewData)) {
            case 'NULL':
                $engineName .= 'DummyView';
                break;
            case 'string':
                $engineName .= $settings['engine'];
                break;
        }

        $view = new $engineName;
        $view->engine($settings);
        $view->file($this->viewData);

        return $view;
    }
}
