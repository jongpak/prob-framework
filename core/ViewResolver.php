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
        $engineClassName = '\\App\\ViewEngine\\';

        switch (gettype($this->viewData)) {
            case 'string':
                $engineClassName .= $settings['engine'];
                break;

            case 'array':
            case 'object':
                $engineClassName .= 'Json';
                break;

            case 'NULL':
            default:
                $engineClassName .= 'DummyView';
                break;
        }

        $view = new $engineClassName;
        $view->engine($settings);
        $view->file($this->viewData);

        return $view;
    }
}
