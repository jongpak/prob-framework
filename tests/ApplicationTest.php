<?php

namespace Core;

use PHPUnit\Framework\TestCase;
use Prob\Router\Map;
use Prob\Rewrite\Request;
use App\Controller\TestController;
use App\ViewEngine\Twig;

class ApplicationTest extends TestCase
{
    /**
     * @var Application
     */
    private $application;

    public function setUp()
    {
        include_once 'mock/TestController.php';

        $application = Application::getInstance();
        $application->setSiteConfig($this->getSiteConfig());
        $application->setErrorReporterConfig($this->getErrorReporterConfig());
        $application->setViewEngineConfig($this->getViewEngineConfig());
        $application->setRouterConfig($this->getRouteMap());

        $this->application = $application;
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
            'namespace' => 'App\\ErrorReporter',

            'Html' => [
                'class' => 'Html'
            ]
        ];
    }

    private function getViewEngineConfig()
    {
        return [
            'Twig' => [
                'class' => 'Twig',
                'path' => __DIR__ . '/mock',
                'postfix' => '.twig',
                'settings' => []
            ]
        ];
    }

    private function getRouteMap()
    {
        return [
            'namespace' => 'App\\Controller',

            '/test' => 'TestController.echoTest',

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
            ]
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
        $this->application->dispatcher(new Request());
    }

    public function testGetStringDispatcher()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['PATH_INFO'] = '/string/free/5';

        $this->expectOutputString(TestController::generateViewModelKeyValue('GET', 'free', '5'));
        $this->application->dispatcher(new Request());
    }

    public function testPostStringDispatcher()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['PATH_INFO'] = '/string/free/5';

        $this->expectOutputString(TestController::generateViewModelKeyValue('POST', 'free', '5'));
        $this->application->dispatcher(new Request());
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetJsonDispatcher()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['PATH_INFO'] = '/json/free/5';

        $this->expectOutputString(json_encode(TestController::generateJsonArray('GET', 'free', '5')));
        $this->application->dispatcher(new Request());
    }

    /**
     * @runInSeparateProcess
     */
    public function testPostJsonDispatcher()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['PATH_INFO'] = '/json/free/5';

        $this->expectOutputString(json_encode(TestController::generateJsonArray('POST', 'free', '5')));
        $this->application->dispatcher(new Request());
    }

    public function testGetDummyDispatcher()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['PATH_INFO'] = '/dummy/free/5';

        $this->expectOutputString(TestController::generateViewModelKeyValue('GET', 'free', '5'));
        $this->application->dispatcher(new Request());
    }

    public function testPostDummyDispatcher()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['PATH_INFO'] = '/dummy/free/5';

        $this->expectOutputString(TestController::generateViewModelKeyValue('POST', 'free', '5'));
        $this->application->dispatcher(new Request());
    }

    public function testUrl()
    {
        $siteUrl = $this->getSiteConfig()['url'];
        $url = '/test/ok';

        $expectUrl = $siteUrl.$url;

        $this->assertEquals($expectUrl, $this->application->url($url));
    }
}
