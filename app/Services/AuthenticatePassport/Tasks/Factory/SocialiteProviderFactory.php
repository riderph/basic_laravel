<?php

namespace App\Services\AuthenticatePassport\Tasks\Factory;

use App\Services\AuthenticatePassport\Tasks\Interface\OAuth2Provider;

class SocialiteProviderFactory
{
    public function __construct(
        protected OAuth2Provider $provider,
    ) {}

    public function createProvider()
    {
        return $this->provider->createProvider();
    }
}
