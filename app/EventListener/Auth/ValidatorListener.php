<?php

namespace App\EventListener\Auth;

use Prob\Handler\ProcInterface;

class ValidatorListener
{
    public function validate(ProcInterface $proc)
    {
        $validator = new Validator(require 'config/controllerPermission.php');
        $validator->validate($proc);
    }
}
