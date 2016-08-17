<?php

namespace App\Controller;

class Test
{
    public function hello()
    {
        echo 'Hello Test!';
    }

    public function showPostList($board)
    {
        return [
            'board' => $board,
            'posts' => [
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
            ]
        ];
    }
}
