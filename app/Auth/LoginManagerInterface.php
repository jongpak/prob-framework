<?php

namespace App\Auth;

interface LoginManagerInterface
{
    public function __construct(array $settings = []);

    public function login($accountId, $password);
    public function logout();

    public function isLogged();

    public function getLoggedAccountId();
}
