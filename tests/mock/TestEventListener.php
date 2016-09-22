<?php

namespace App\EventListener;

class TestEventListener
{
    private $str;

    public function __construct($str1, $str2)
    {
        $this->str = 'construct_' . $str1 . $str2;
    }

    public function printText()
    {
        echo $this->str;
    }
}
