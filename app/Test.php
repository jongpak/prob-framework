<?php

namespace App\Controller;

use Core\Application;
use Core\Utils\EntityFinder;
use App\Entity\Post;

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

    public function dbTest()
    {
        return EntityFinder::findAll(Post::class);
    }

    public function goMain()
    {
        return 'redirect: ' . Application::getUrl();
    }

    public function event()
    {
        echo 'Event!';
    }

    public function admin()
    {
        echo 'Admin page';
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
