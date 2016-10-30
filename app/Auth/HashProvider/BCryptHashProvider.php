<?php

namespace App\Auth\HashProvider;

use App\Auth\HashProviderInterface;

class BCryptHashProvider implements HashProviderInterface
{
    public function __construct($settings = [])
    {
    }

    public function make($value)
    {
        return password_hash($value, PASSWORD_DEFAULT);
    }

    public function isEqualValueAndHash($plainString, $hash)
    {
        return password_verify($plainString, $hash);
    }
}