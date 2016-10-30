<?php

namespace App\Auth;

interface HashProviderInterface
{
    public function __construct($settings = []);

    public function make($value);
    public function isEqualValueAndHash($string, $hash);
}