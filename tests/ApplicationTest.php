<?php

namespace Core;

use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    private function getConfig1()
    {
        return [
            'url' => '/prob/',
            'publicPath' => '/prob/public/',
        ];
    }

    private function getConfig2()
    {
        return [
            'url' => '/prob',
            'publicPath' => '/prob/public',
        ];
    }

    public function testRootUrl()
    {
        Application::setConfig($this->getConfig1());
        $this->assertEquals('/prob/', Application::getUrl());
        $this->assertEquals('/prob/', Application::getUrl('/'));

        Application::setConfig($this->getConfig2());
        $this->assertEquals('/prob/', Application::getUrl());
        $this->assertEquals('/prob/', Application::getUrl('/'));
    }

    public function testUrl()
    {
        Application::setConfig($this->getConfig1());
        $this->assertEquals('/prob/test/ok', Application::getUrl('test/ok'));
        $this->assertEquals('/prob/test/ok', Application::getUrl('/test/ok'));

        Application::setConfig($this->getConfig2());
        $this->assertEquals('/prob/test/ok', Application::getUrl('test/ok'));
        $this->assertEquals('/prob/test/ok', Application::getUrl('/test/ok'));
    }

    public function testPublicUrl()
    {
        Application::setConfig($this->getConfig1());
        $this->assertEquals('/prob/public/style.css', Application::getPublicUrl('style.css'));
        $this->assertEquals('/prob/public/style.css', Application::getPublicUrl('/style.css'));

        Application::setConfig($this->getConfig2());
        $this->assertEquals('/prob/public/style.css', Application::getPublicUrl('style.css'));
        $this->assertEquals('/prob/public/style.css', Application::getPublicUrl('/style.css'));
    }
}
