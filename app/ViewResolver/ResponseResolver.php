<?php

namespace App\ViewResolver;

use Core\View\ViewResolverInterface;
use Core\Utils\ResponseProxy;
use Psr\Http\Message\ResponseInterface;

class ResponseResolver implements ViewResolverInterface
{
    /**
     * @var ResponseProxy
     */
    private static $responseProxy = null;

    public static function getResponseProxyInstance()
    {
        if (self::$responseProxy === null) {
            self::$responseProxy = new ResponseProxy();
        }

        return self::$responseProxy;
    }

    public function setViewEngineConfig(array $settings)
    {
    }

    public function resolve($viewData)
    {
        if (self::$responseProxy === null || self::$responseProxy->getResponse() === null) {
            return;
        }

        /** @var ResponseInterface */
        $response = self::$responseProxy->getResponse();

        if ($response->getStatusCode()) {
            header(sprintf('HTTP/%s %d %s',
                $response->getProtocolVersion(),
                $response->getStatusCode(),
                $response->getReasonPhrase()
            ));
        }

        foreach ($response->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                header($name . ':' . $value);
            }
        }
    }
}
