<?php

namespace App\Controller;

use App\Entity\Post;

use Core\Application;
use Doctrine\ORM\EntityManager;

class Test
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct()
    {
        $this->entityManager = Application::getInstance()->getEntityManager();
    }

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
        $posts = $this->entityManager->getRepository(Post::class)->findAll();
        return $posts;
    }

    public function goMain()
    {
        return 'redirect: ' . Application::getInstance()->url();
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
