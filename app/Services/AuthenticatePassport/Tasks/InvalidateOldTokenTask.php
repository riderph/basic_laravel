<?php

namespace App\Services\AuthenticatePassport\Tasks;

use App\Services\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;

class InvalidateOldTokenTask extends Task
{

    public function __construct(
        protected TokenRepository $tokenRepository,
        protected RefreshTokenRepository $refreshTokenRepository
    ) {
    }
    /**
     * Get data when login successfully
     *
     * @return void
     */
    public function run()
    {
        if (!is_null(Auth::user())) {
            // DB::table('oauth_access_tokens')->where([
            //     'user_id' => Auth::user()->id
            // ])->update(
            //     ['revoked' => 1]
            // );
        }
    }
}
