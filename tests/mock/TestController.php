<?php

namespace App\Controller;

use Core\ViewModel;

class TestController
{
    public static function generateViewModelKeyValue($method, $board, $post)
    {
        return $method . ': /' . $board . '/' . $post;
    }

    public static function generateJsonArray($method, $board, $post)
    {
        return [ $method, $board, $post ];
    }

    public function echoTest()
    {
        echo 'Test!';
    }

    public function getString($board, $post, ViewModel $model)
    {
        $model->set('key', $this->generateViewModelKeyValue('GET', $board, $post));
        return 'test';
    }

    public function postString($board, $post, ViewModel $model)
    {
        $model->set('key', $this->generateViewModelKeyValue('POST', $board, $post));
        return 'test';
    }

    public function getJson($board, $post)
    {
        return $this->generateJsonArray('GET', $board, $post);
    }

    public function postJson($board, $post)
    {
        return $this->generateJsonArray('POST', $board, $post);
    }

    public function getDummy($board, $post)
    {
        echo $this->generateViewModelKeyValue('GET', $board, $post);
    }

    public function postDummy($board, $post)
    {
        echo $this->generateViewModelKeyValue('POST', $board, $post);
    }

    public function eventTest()
    {
        echo 'Controller!';
    }
}
