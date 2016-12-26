<?php

namespace App\Controller\Admin;

use PHPUnit\Framework\TestCase;

class AdminServiceTest extends TestCase
{
    public function testGetEnvironment() {
        AdminService::setEnvironment([
            'key' => 'value'
        ]);

        $this->assertEquals('value', AdminService::getEnvironment('key'));
    }

    public function testGetRoutePaths() {
        AdminService::setEnvironment([
            'router' => [
                '/url_1' => 'handler1',
                '/url_2' => 'handler2',
            ]
        ]);

        $this->assertEquals([
            '/url_1' => 'handler1',
            '/url_2' => 'handler2',
        ], AdminService::getRoutePaths());
    }

    public function testGetEventHandler() {
        AdminService::setEnvironment([
            'event' => [
                'event1' => 'handler1',
                'event2' => 'handler2',
            ]
        ]);

        $this->assertEquals([
            'event1' => 'handler1',
            'event2' => 'handler2',
        ], AdminService::getEventHandlers());
    }
}