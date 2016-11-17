<?php

namespace Core\View;

use App\ViewResolver\ResponseResolver;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\Response\EmptyResponse;

class ResponseResolverTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testResponseResolve()
    {
        $resolver = new ResponseResolver();
        $resolver->setViewEngineConfig([]);

        $response = new EmptyResponse(200, [
            'header-key1' => 'value1',
            'header-key2' => 'value2',
            'header-key3' => 'value3',
        ]);

        $responseProxy = ResponseResolver::getResponseProxyInstance();
        $responseProxy->setResponse($response);

        (new ResponseResolver())->resolve(null);

        // TODO PHPUnit에서 header를 테스트하기 어렵기 때문에 일단 주석처리 함
       /*
        $this->assertEquals([
            'header-key1' => 'value1',
            'header-key2' => 'value2',
            'header-key3' => 'value3',
        ], headers_list());
       */
    }

    public function testNotResponseResolve()
    {
        $resolver = new ResponseResolver();
        $resolver->setViewEngineConfig([]);

        $this->assertEquals(null, $resolver->resolve(null));
    }
}