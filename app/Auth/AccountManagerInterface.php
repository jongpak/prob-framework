<?php

namespace App\Auth;

interface AccountManagerInterface
{
    public function __construct($settings = []);

    /**
     * @param  string  $accountId
     * @return boolean
     */
    public function isExistAccountId($accountId);

    /**
     * @param  string  $accountId
     * @param  string  $password
     * @return boolean
     */
    public function isEqualPassword($accountId, $password);

    /**
     * @param  string  $accountId
     * @return array|null
     */
    public function getRole($accountId);
}
