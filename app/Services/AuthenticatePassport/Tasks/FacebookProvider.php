<?php

namespace App\Services\AuthenticatePassport\Tasks;

use App\Services\AuthenticatePassport\Tasks\Interface\OAuth2Provider;
use Laravel\Socialite\Facades\Socialite;

class FacebookProvider implements OAuth2Provider
{
    public function createProvider()
    {
        return Socialite::driver('facebook');
    }
}
