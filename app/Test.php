<?php

namespace App\Controller;

class Test
{
    public function echoTest()
    {
        echo 'Hello Test!';
    }

    public function paramTest($name)
    {
        echo 'Hello ' . $name . '!';
    }

    public function jsonTest()
    {
        return [
            [
                'title' => 'title 1',
                'content' => 'content 1'
            ],
            [
                'title' => 'title 2',
                'content' => 'content 2'
            ],
            [
                'title' => 'title 3',
                'content' => 'content 3'
            ]
        ];
    }
}
