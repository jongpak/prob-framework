<?php

namespace Core;

use PHPUnit\Framework\TestCase;
use Prob\Router\Map;
use Prob\Rewrite\Request;
use App\ViewEngine\StringViewForApplicationTest;
use App\Controller\TestController;

class ApplicationTest extends TestCase
{
    /**
     * @var Application
     */
    private $application;

    public function setUp()
    {
        include_once 'mock/StringViewForApplicationTest.php';
        include_once 'mock/TestController.php';

        $application = Application::getInstance();
        $application->setSiteConfig($this->getSiteConfig());
        $application->setViewEngineConfig($this->getViewEngineConfig());
        $application->setRouterConfig($this->getRouteMap());

        $this->application = $application;
    }

    private function getSiteConfig()
    {
        return [
            'url' => 'http://test.com/',
            'viewEngine' => 'StringViewForApplicationTest'
        ];
    }

    private function getViewEngineConfig()
    {
        return [
            'StringViewForApplicationTest' => [
                'class' => 'StringViewForApplicationTest'
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

    private function setUpRequestAndPathInfo($method, $prefix, $board, $post)
    {
        $_SERVER['REQUEST_METHOD'] = $method;
        $_SERVER['PATH_INFO'] = '/'. $prefix . '/' . $board . '/' . $post;
    }

    public function testGetStringDispatcherByDefaultGetMap()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['PATH_INFO'] = '/test';

        $controller = new TestController();

        $this->expectOutputString('Test!');
        $this->application->dispatcher(new Request());
    }

    public function testGetStringDispatcher()
    {
        $method = 'GET';
        $prefix = 'string';
        $board = 'free';
        $post = '5';

        $view = new StringViewForApplicationTest();
        $controller = new TestController();
        $viewModel = new ViewModel();

        $returnOfController = $controller->getString($board, $post, $viewModel);
        $view->file($returnOfController);
        $view->set('key', $viewModel->getVariables()['key']);

        $this->expectOutputString($view->getRenderingResult());

        $this->setUpRequestAndPathInfo($method, $prefix, $board, $post);
        $this->application->dispatcher(new Request());
    }

    public function testPostStringDispatcher()
    {
        $method = 'POST';
        $prefix = 'string';
        $board = 'free';
        $post = '5';

        $view = new StringViewForApplicationTest();
        $controller = new TestController();
        $viewModel = new ViewModel();

        $returnOfController = $controller->postString($board, $post, $viewModel);
        $view->file($returnOfController);
        $view->set('key', $viewModel->getVariables()['key']);

        $this->expectOutputString($view->getRenderingResult());

        $this->setUpRequestAndPathInfo($method, $prefix, $board, $post);
        $this->application->dispatcher(new Request());
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetJsonDispatcher()
    {
        $method = 'GET';
        $prefix = 'json';
        $board = 'free';
        $post = '5';

        $controller = new TestController();

        $jsonResult = json_encode($controller->getJson($board, $post));
        $this->expectOutputString($jsonResult);

        $this->setUpRequestAndPathInfo($method, $prefix, $board, $post);
        $this->application->dispatcher(new Request());
    }

    /**
     * @runInSeparateProcess
     */
    public function testPostJsonDispatcher()
    {
        $method = 'POST';
        $prefix = 'json';
        $board = 'free';
        $post = '5';

        $controller = new TestController();

        $jsonResult = json_encode($controller->postJson($board, $post));
        $this->expectOutputString($jsonResult);

        $this->setUpRequestAndPathInfo($method, $prefix, $board, $post);
        $this->application->dispatcher(new Request());
    }

    public function testGetDummyDispatcher()
    {
        $method = 'GET';
        $prefix = 'dummy';
        $board = 'free';
        $post = '5';

        $controller = new TestController();

        $this->expectOutputString($controller->generateViewModelKeyValue($method, $board, $post));

        $this->setUpRequestAndPathInfo($method, $prefix, $board, $post);
        $this->application->dispatcher(new Request());
    }

    public function testPostDummyDispatcher()
    {
        $method = 'POST';
        $prefix = 'dummy';
        $board = 'free';
        $post = '5';

        $controller = new TestController();

        $this->expectOutputString($controller->generateViewModelKeyValue($method, $board, $post));

        $this->setUpRequestAndPathInfo($method, $prefix, $board, $post);
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
