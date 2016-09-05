<?php

namespace Core;

use PHPUnit\Framework\TestCase;
use Prob\Router\Map;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Uri;
use App\Controller\TestController;

class ApplicationTest extends TestCase
{
    /**
     * @var Application
     */
    private $application;

    public function setUp()
    {
        include_once 'mock/TestController.php';

        static $inc = 0;

        $application = Application::getInstance();
        $this->application = $application;

        if ($inc > 0) {
            return;
        }
        $inc++;

        $application->setSiteConfig($this->getSiteConfig());
        $application->setErrorReporterConfig($this->getErrorReporterConfig());
        $application->setViewEngineConfig($this->getViewEngineConfig());
        $application->setViewResolver($this->getViewResolvers());

        $application->setEventListener($this->getEventListener());
        $application->registerEventListener();

        $application->setRouterConfig($this->getRouteMap());
    }

    private function getSiteConfig()
    {
        return [
            'url' => 'http://test.com/',
            'displayErrors' => true,
            'errorReporters' => [ 'Html' ]
        ];
    }

    private function getErrorReporterConfig()
    {
        return [
            'Html' => [
                'class' => 'App\\ErrorReporter\\Html',
                'view' => 'App\\ViewEngine\\Twig',
                'path' => __DIR__ . '/mock',
                'file' => 'error',
                'postfix' => '.twig',
                'settings' => []
            ]
        ];
    }

    private function getViewEngineConfig()
    {
        return [
            'Twig' => [
                'path' => __DIR__ . '/mock',
                'postfix' => '.twig',
                'settings' => []
            ]
        ];
    }

    private function getViewResolvers()
    {
        return [
            'App\ViewResolver\DummyResolver',
            'App\ViewResolver\RedirectResolver',
            'Twig' => 'App\ViewResolver\TwigResolver',
            'App\ViewResolver\JsonResolver'
        ];
    }

    private function getEventListener()
    {
        return [
            'Controller' => [
                '{closure}' => [
                    'before' => function ($urlPattern) {
                        if ($urlPattern !== '/test/event2') {
                            return;
                        }
                        echo '[before closure!]';
                    },
                    'after' => function ($urlPattern) {
                        if ($urlPattern !== '/test/event2') {
                            return;
                        }
                        echo '[after closure!]';
                    },
                ],
                'TestController.eventTest' => [
                    'before' => function () {
                        echo '[before controller!]';
                    },
                    'after' => function () {
                        echo '[after controller!]';
                    },
                ]
            ]
        ];
    }

    private function getRouteMap()
    {
        return [
            'namespace' => 'App\\Controller',

            '/test' => 'TestController.echoTest',
            '/test/closure1' => function () {
                echo 'Test!';
            },

            '/test/closure2' => [
                'GET' => function () {
                    echo 'GET Test!';
                },
                'POST' => function () {
                    echo 'POST Test!';
                }
            ],

            '/string/{board}/{post}' => [
                'GET' => 'TestController.getString',
                'POST' => 'TestController.postString'
            ],

            '/json/{board}/{post}' => [
                'GET' => 'TestController.getJson',
                'POST' => 'TestController.postJson'
            ],

            '/dummy/{board}/{post}' => [
                'GET' => 'TestController.getDummy',
                'POST' => 'TestController.postDummy'
            ],

            '/test/event1' => 'TestController.eventTest',
            '/test/event2' => function () {
                echo 'Closure!';
            }
        ];
    }

    public function testSettingDisplayErrors()
    {
        $isDisplayErrors = true;

        // clean
        $prev = ini_get('display_errors');
        ini_set('display_errors', !$isDisplayErrors);

        // test set
        $this->application->setDisplayError($isDisplayErrors);
        $curr = ini_get('display_errors');

        // restore
        ini_set('display_errors', $prev);

        $this->assertEquals($isDisplayErrors, $curr);
    }


    public function testGetStringDispatcherByDefaultGetMap()
    {
        $this->expectOutputString('Test!');
        $this->application->dispatch(
            (new ServerRequest())
                ->withUri(new Uri('/test'))
                ->withMethod('GET')
        );
    }

    public function testClosure1GetMethod()
    {
        $this->expectOutputString('Test!');
        $this->application->dispatch(
            (new ServerRequest())
                ->withUri(new Uri('/test/closure1'))
                ->withMethod('GET')
        );
    }

    public function testClosure2GetMethod()
    {
        $this->expectOutputString('GET Test!');
        $this->application->dispatch(
            (new ServerRequest())
                ->withUri(new Uri('/test/closure2'))
                ->withMethod('GET')
        );
    }

    public function testClosure2PostMethod()
    {
        $this->expectOutputString('POST Test!');
        $this->application->dispatch(
            (new ServerRequest())
                ->withUri(new Uri('/test/closure2'))
                ->withMethod('POST')
        );
    }

    public function testGetStringDispatcher()
    {
        $this->expectOutputString(TestController::generateViewModelKeyValue('GET', 'free', '5'));
        $this->application->dispatch(
            (new ServerRequest())
                ->withUri(new Uri('/string/free/5'))
                ->withMethod('GET')
        );
    }

    public function testPostStringDispatcher()
    {
        $this->expectOutputString(TestController::generateViewModelKeyValue('POST', 'free', '5'));
        $this->application->dispatch(
            (new ServerRequest())
                ->withUri(new Uri('/string/free/5'))
                ->withMethod('POST')
        );
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetJsonDispatcher()
    {
        $this->expectOutputString(json_encode(TestController::generateJsonArray('GET', 'free', '5')));
        $this->application->dispatch(
            (new ServerRequest())
                ->withUri(new Uri('/json/free/5'))
                ->withMethod('GET')
        );
    }

    /**
     * @runInSeparateProcess
     */
    public function testPostJsonDispatcher()
    {
        $this->expectOutputString(json_encode(TestController::generateJsonArray('POST', 'free', '5')));
        $this->application->dispatch(
            (new ServerRequest())
                ->withUri(new Uri('/json/free/5'))
                ->withMethod('POST')
            );
    }

    public function testGetDummyDispatcher()
    {
        $this->expectOutputString(TestController::generateViewModelKeyValue('GET', 'free', '5'));
        $this->application->dispatch(
            (new ServerRequest())
                ->withUri(new Uri('/dummy/free/5'))
                ->withMethod('GET')
        );
    }

    public function testPostDummyDispatcher()
    {
        $this->expectOutputString(TestController::generateViewModelKeyValue('POST', 'free', '5'));
        $this->application->dispatch(
            (new ServerRequest())
                ->withUri(new Uri('/dummy/free/5'))
                ->withMethod('POST')
        );
    }


    public function testControllerEventListener()
    {
        $this->expectOutputString('[before controller!]Controller![after controller!]');
        $this->application->dispatch(
            (new ServerRequest())
                ->withUri(new Uri('/test/event1'))
                ->withMethod('GET')
        );
    }

    public function testClosureEventListener()
    {
        $this->expectOutputString('[before closure!]Closure![after closure!]');
        $this->application->dispatch(
            (new ServerRequest())
                ->withUri(new Uri('/test/event2'))
                ->withMethod('GET')
        );
    }


    public function testUrl()
    {
        $siteUrl = $this->getSiteConfig()['url'];
        $url = '/test/ok';

        $expectUrl = $siteUrl.$url;

        $this->assertEquals($expectUrl, $this->application->url($url));
    }
}
