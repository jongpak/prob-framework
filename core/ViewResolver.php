<?php

namespace Core;

class ViewResolver
{
    private $namespaceOfViewEngine = '\\App\\ViewEngine\\';

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
    public function resolve(array $settings)
    {
        $this->resolveViewType['string'] = $settings['engine'];

        $viewClassName = $this->getResolvedViewClassName();

        $view = new $viewClassName;
        $view->init($settings);
        $view->file($this->viewData);

        return $view;
    }

    private function getResolvedViewClassName()
    {
        $engineClassName = $this->resolveViewType[gettype($this->viewData)];
        return $this->namespaceOfViewEngine . $engineClassName;
    }
}
