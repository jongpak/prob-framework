<?php

namespace Core;

interface View
{
    /**
     * Initial view engine.
     * $engine are used to initialize view.
     *
     * @param array $engine
     * @return mixed
     */
    public function engine($engine = []);

    /**
     * put variable used by rendering
     *
     * @param string $k
     * @param mixed $v
     * @return mixed
     */
    public function set($k, $v);

    /**
     * render view
     *
     * @param string $fileName
     * @return mixed
     */
    public function render($fileName);
}