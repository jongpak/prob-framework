<?php

namespace Core\ControllerDispatcher;

use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;
use Core\ViewModel;
use Prob\Router\Map;
use Prob\Handler\Parameter\Typed;
use Prob\Handler\Parameter\Named;
use Prob\Handler\ProcInterface;
use Psr\Http\Message\ServerRequestInterface;

class ParameterMapperTest extends TestCase
{

    public function testMapping()
    {
        $map = new Map();
        $map->get('/{board:string}/{action:string}', function () { });

        $mapper = new ParameterMapper();
        $mapper->setRequest(new ServerRequest([], [], '/free/write'));
        $mapper->setViewModel(new ViewModel());
        $mapper->setRouterMap($map);

        $parameterMap = $mapper->getParameterMap();

        $this->assertEquals(true, $parameterMap->isExistBy(new Typed(ServerRequestInterface::class)));
        $this->assertEquals(true, $parameterMap->isExistBy(new Typed(ProcInterface::class)));
        $this->assertEquals(true, $parameterMap->isExistBy(new Typed(ViewModel::class)));

        $this->assertEquals('{closure}', $parameterMap->getValueBy(new Typed(ProcInterface::class))->getName());
        $this->assertEquals('/{board:string}/{action:string}', $parameterMap->getValueBy(new Named('urlPattern')));
        $this->assertEquals('free', $parameterMap->getValueBy(new Named('board')));
        $this->assertEquals('write', $parameterMap->getValueBy(new Named('action')));
    }
}
