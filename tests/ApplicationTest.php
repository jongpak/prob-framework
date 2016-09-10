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
            'url' => 'http://test.com/',
        ];
    }

    public function testUrl()
    {
        $siteUrl = $this->getSiteConfig()['url'];
        $url = '/test/ok';

        $expectUrl = $siteUrl.$url;

        $this->assertEquals($expectUrl, $this->application->url($url));
    }
}
