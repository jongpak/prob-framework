<?php

namespace Core\Utils;

use Psr\Http\Message\ResponseInterface;

class ResponseProxy
{
    /**
     * @var ResponseInterface
     */
    private $response;

    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function getResponse()
    {
        return $this->response;
    }
}
