<?php

namespace Core;

interface ViewEngineInterface
{
    /**
     * @param array $settings
     */
    public function __construct($settings = []);

    /**
     * put variable used by rendering
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function set($key, $value);

    /**
     * return variables of view
     * @return array
     */
    public function getVariables();

    /**
     * set rendering file
     *
     * @param $fileName
     * @return mixed
     */
    public function file($fileName);

    /**
     * return rendering file
     *
     * @return mixed
     */
    public function getFile();

    /**
     * render view
     *
     * @return mixed
     */
    public function render();
}
