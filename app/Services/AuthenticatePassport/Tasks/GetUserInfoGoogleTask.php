<?php

namespace App\Services\AuthenticatePassport\Tasks;

use App\Exceptions\ForbiddenException;
use App\Services\AuthenticatePassport\Tasks\Factory\SocialiteProviderFactory;
use App\Services\Task;
use Exception;
use Illuminate\Support\Facades\Log;

class GetUserInfoGoogleTask extends Task
{

    /**
     * Execute task
     *
     * @param array $credentials Data login
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function run(string $token)
    {
        try {
            $provider = new SocialiteProviderFactory(new GoogleProvider());
            $user = $provider->createProvider()->userFromToken($token);
            return $user;
        } catch (Exception $e) {
            Log::error("[GerUserGoogleError] ::" . $e->getMessage() . "\n Line: " . $e->getLine() . "\n File: " . $e->getFile());
            throw new ForbiddenException(trans('auth.failed'));
        }
    }
}
