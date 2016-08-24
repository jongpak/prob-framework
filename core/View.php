<?php

namespace Core;

interface View
{
    /**
     * Initial view engine.
     * $engine are used to initialize view.
     *
     * @param array $setting
     * @return mixed
     */
    public function init($setting = []);

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
