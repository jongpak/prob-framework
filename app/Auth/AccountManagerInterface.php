<?php

namespace App\Auth;

interface AccountManagerInterface
{
    public function __construct($settings = []);

    public function isExistAccountId($accountId);
    public function isEqualPassword($accountId, $password);

    public function getRole($accountId);
}
