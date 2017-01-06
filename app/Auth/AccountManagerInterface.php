<?php

namespace App\Auth;

use App\Auth\Model\Account;

interface AccountManagerInterface
{
    public function __construct(array $settings = []);

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
     * @param string $accountId
     * @return Account|null
     */
    public function getAccountById($accountId);

    /**
     * @param  string  $accountId
     * @return array|null
     */
    public function getRole($accountId);
}
