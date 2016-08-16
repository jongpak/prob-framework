<?php

namespace Core;

class ViewResolver
{
    /**
     * raw view data (return value of controller)
     *
     * @var mixed
     */
    private $viewData;

    private $resolveViewType = [
        'string' => null,
        'array'  => 'Json',
        'object' => 'Json',
        'NULL'   => 'DummyView'
    ];

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
     * Return resolved View instance
     *
     * @param array $settings View engine settings
     * @return View
     */
    public function resolve($settings)
    {
        $this->resolveViewType['string'] = $settings['engine'];

        $engineClassName = $this->resolveViewType[gettype($this->viewData)];
        $engineClassFullName = '\\App\\ViewEngine\\' . $engineClassName;

        $view = new $engineClassFullName;
        $view->init($settings);
        $view->file($this->viewData);

        return $view;
    }
}
