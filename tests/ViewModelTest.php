<?php

namespace Core;

use PHPUnit\Framework\TestCase;

class ViewModelTest extends TestCase
{
    public function testSetVariable()
    {
        $viewModel = new ViewModel();
        $viewModel->set('key1', 'one');
        $viewModel->set('key2', 'two');
        $viewModel->set('key3', 3);
        $viewModel->set('key4', null);
        $viewModel->set('key5', ['test', 'ok']);

        $this->assertEquals([
            'key1' => 'one',
            'key2' => 'two',
            'key3' => 3,
            'key4' => null,
            'key5' => ['test', 'ok']
        ], $viewModel->getVariables());
    }
}
