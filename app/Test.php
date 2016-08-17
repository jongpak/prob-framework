<?php

namespace App\Controller;

use App\Entity\Post;

use Core\Framework;
use Doctrine\ORM\EntityManager;

class Test
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct()
    {
        $this->entityManager = Framework::getInstance()->getEntityManager();
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
