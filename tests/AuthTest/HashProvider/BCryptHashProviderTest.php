<?php

namespace App\Auth;

use App\Auth\HashProvider\BCryptHashProvider;
use PHPUnit\Framework\TestCase;

class BCryptHashProviderTest extends TestCase
{
    public function testMakeAndVerify()
    {
        $bcryptProvider = new BCryptHashProvider();

        $plainString = 'test!!';
        $hashedString = $bcryptProvider->make($plainString);

        $this->assertEquals(true, $bcryptProvider->isEqualValueAndHash($plainString, $hashedString));
    }
}
