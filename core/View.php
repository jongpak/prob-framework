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
    public function engine($setting = []);

    /**
     * put variable used by rendering
     *
     * @param string $k
     * @param mixed $v
     * @return mixed
     */
    public function set($k, $v);

    /**
     * set rendering file
     *
     * @param $fileName
     * @return mixed
     */
    public function file($fileName);

    /**
     * render view
     *
     * @return mixed
     */
    public function render();
}
