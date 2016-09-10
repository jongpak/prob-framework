<?php

namespace Core;

use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    /**
     * @var Application
     */
    private $application;

    public function setUp()
    {
        $application = Application::getInstance();
        $application->setSiteConfig($this->getSiteConfig());

        $this->application = $application;
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
        $this->assertEquals('/prob/', $this->application->url());
        $this->assertEquals('/prob/', $this->application->url('/'));
    }

    public function testUrl()
    {
        $this->assertEquals('/prob/test/ok', $this->application->url('test/ok'));
    }

    public function testPublicUrl()
    {
        $this->assertEquals('/prob/public/style.css', $this->application->getPublicUrl('style.css'));
    }
}
