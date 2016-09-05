<?php

namespace Core;

use PHPUnit\Framework\TestCase;
use Prob\Router\Map;
use Prob\Rewrite\Request;
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

        $application->setEventListener($this->getEventListener());
        $application->registerEventListener();

        $application->setRouterConfig($this->getRouteMap());
    }

    private function getSiteConfig()
    {
        return [
            'url' => 'http://test.com/',
            'viewEngine' => 'Twig',
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
                'class' => 'App\\ViewEngine\\Twig',
                'path' => __DIR__ . '/mock',
                'postfix' => '.twig',
                'settings' => []
            ]
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
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['PATH_INFO'] = '/test';

        $this->expectOutputString('Test!');
        $this->application->dispatch(new Request());
    }

    public function testClosure1GetMethod()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['PATH_INFO'] = '/test/closure1';

        $this->expectOutputString('Test!');
        $this->application->dispatch(new Request());
    }

    public function testClosure2GetMethod()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['PATH_INFO'] = '/test/closure2';

        $this->expectOutputString('GET Test!');
        $this->application->dispatch(new Request());
    }

    public function testClosure2PostMethod()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['PATH_INFO'] = '/test/closure2';

        $this->expectOutputString('POST Test!');
        $this->application->dispatch(new Request());
    }

    public function testGetStringDispatcher()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['PATH_INFO'] = '/string/free/5';

        $this->expectOutputString(TestController::generateViewModelKeyValue('GET', 'free', '5'));
        $this->application->dispatch(new Request());
    }

    public function testPostStringDispatcher()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['PATH_INFO'] = '/string/free/5';

        $this->expectOutputString(TestController::generateViewModelKeyValue('POST', 'free', '5'));
        $this->application->dispatch(new Request());
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetJsonDispatcher()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['PATH_INFO'] = '/json/free/5';

        $this->expectOutputString(json_encode(TestController::generateJsonArray('GET', 'free', '5')));
        $this->application->dispatch(new Request());
    }

    /**
     * @runInSeparateProcess
     */
    public function testPostJsonDispatcher()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['PATH_INFO'] = '/json/free/5';

        $this->expectOutputString(json_encode(TestController::generateJsonArray('POST', 'free', '5')));
        $this->application->dispatch(new Request());
    }

    public function testGetDummyDispatcher()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['PATH_INFO'] = '/dummy/free/5';

        $this->expectOutputString(TestController::generateViewModelKeyValue('GET', 'free', '5'));
        $this->application->dispatch(new Request());
    }

    public function testPostDummyDispatcher()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['PATH_INFO'] = '/dummy/free/5';

        $this->expectOutputString(TestController::generateViewModelKeyValue('POST', 'free', '5'));
        $this->application->dispatch(new Request());
    }


    public function testControllerEventListener()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['PATH_INFO'] = '/test/event1';

        $this->expectOutputString('[before controller!]Controller![after controller!]');
        $this->application->dispatch(new Request());
    }

    public function testClosureEventListener()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['PATH_INFO'] = '/test/event2';

        $this->expectOutputString('[before closure!]Closure![after closure!]');
        $this->application->dispatch(new Request());
    }


    public function testUrl()
    {
        $siteUrl = $this->getSiteConfig()['url'];
        $url = '/test/ok';

        $expectUrl = $siteUrl.$url;

        $this->assertEquals($expectUrl, $this->application->url($url));
    }
}
