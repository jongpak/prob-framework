<?php

namespace Core;

use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    public function setUp()
    {
        Application::setConfig($this->getSiteConfig());
    }

    private function getSiteConfig()
    {
        return [
            'url' => '/prob/',
            'publicPath' => '/prob/public/',
        ];
    }

    public function testRootUrl()
    {
        $this->assertEquals('/prob/', Application::getUrl());
        $this->assertEquals('/prob/', Application::getUrl('/'));
    }

    public function testUrl()
    {
        $this->assertEquals('/prob/test/ok', Application::getUrl('test/ok'));
    }

    public function testPublicUrl()
    {
        $this->assertEquals('/prob/public/style.css', Application::getPublicUrl('style.css'));
    }
}
