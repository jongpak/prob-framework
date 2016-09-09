<?php

namespace App\EventListener\Auth\Test\Mock;

use Prob\Handler\ParameterMap;
use Prob\Handler\ProcInterface;

class TestAdminProc implements ProcInterface
{
    public function __construct($procedure, $namespace = '')
    {
        // ...
    }

    public function getNamespace()
    {
        // ...
    }
    public function getName()
    {
        return 'Test.admin';
    }

    public function exec(...$args)
    {
        // ...
    }

    public function execWithParameterMap(ParameterMap $map)
    {
        // ...
    }
}
