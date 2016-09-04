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
        'array'  => 'App\\ViewEngine\\Json',
        'object' => 'App\\ViewEngine\\Json',
        'NULL'   => 'App\\ViewEngine\\DummyView',
        'redirect' => 'App\\ViewEngine\\Redirect'
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
        $this->resolveViewType['string'] = $settings['class'];

        $viewClassName = $this->getResolvedViewClassName();

        $view = new $viewClassName($settings);
        $view->file($this->isRedirectView() ? $this->getRedirectUrl() : $this->viewData);

        return $view;
    }

    private function getResolvedViewClassName()
    {
        $engineClassName = $this->resolveViewType[gettype($this->viewData)];

        if ($this->isRedirectView()) {
            $engineClassName = $this->resolveViewType['redirect'];
        }

        return $engineClassName;
    }

    private function isRedirectView()
    {
        if (gettype($this->viewData) !== 'string') {
            return false;
        }
        return preg_match('/redirect:(.*)/', $this->viewData) > 0;
    }

    private function getRedirectUrl()
    {
        preg_match('/redirect:(.*)/', $this->viewData, $url);
        return trim($url[1]);
    }
}
