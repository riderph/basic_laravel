<?php

namespace App\Services\AuthenticatePassport\Actions;

use App\Exceptions\ForbiddenException;
use App\Models\User;
use App\Services\Action;
use App\Services\AuthenticatePassport\Tasks\CreateUserFromSocial;
use App\Services\AuthenticatePassport\Tasks\GetInfoUser;
use App\Services\AuthenticatePassport\Tasks\GetUserInfoGoogleTask;
use Exception;
use Laravel\Passport\Bridge\RefreshTokenRepository;

class LoginGoogleAction extends Action
{
    public function __construct(
        protected RefreshTokenRepository $refreshTokenRepository
    ) {
    }
    /**
     * Execute action
     *
     * @param string $token
     *
     * @return mixed
     *
     * @throws \App\Exceptions\ValidatorException
     */
    public function run(string $token)
    {
        /**
         * 1. Get info user from gg by token
         *      - gg id
         *      - email
         *      - name
         *      - avatar
         * 2. check info -> if not exist -> create new user -> next step
         *               -> if exist -> next step
         * 3. generate access token
         * 4. return
         */
        $userInfoGoogle = resolve(GetUserInfoGoogleTask::class)->run($token);
        if (empty($userInfoGoogle)) {
            throw new ForbiddenException(trans('auth.failed'));
        }
        // check user exists in db
        $user = resolve(GetInfoUser::class)->run([
            'email' => $userInfoGoogle->email
        ]);

        if (empty($user)) {
            // create new user
            $user = resolve(CreateUserFromSocial::class)->run([
                'email' => $userInfoGoogle->getEmail(),
                'provider' => config('constants.provider_google'),
                'provider_id' => $userInfoGoogle->getId(),
                'name' => $userInfoGoogle->getEmail(),
                'password' => null
            ]);
        }

        // generate access token
        $token = $user->createToken('Access Token')->accessToken;
        return [
            'user' => $user,
            'access_token' => $token,
        ];
    }
}
