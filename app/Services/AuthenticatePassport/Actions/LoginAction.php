<?php

namespace App\Services\AuthenticatePassport\Actions;

use App\Services\Action;
use App\Services\AuthenticatePassport\Tasks\GetLoginUserTask;
use App\Services\AuthenticatePassport\Tasks\InvalidateOldTokenTask;
use App\Services\AuthenticatePassport\Tasks\ValidateLoginDataTask;

class LoginAction extends Action
{
    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct() {
    }

    /**
     * Execute action
     *
     * @param array $credentials Data
     *
     * @return mixed
     *
     * @throws \App\Exceptions\ValidatorException
     */
    public function run(array $credentials)
    {

        $data = resolve(ValidateLoginDataTask::class)->run($credentials);

        $user = resolve(GetLoginUserTask::class)->run($data);

        resolve(InvalidateOldTokenTask::class)->run();

        $token = $user->createToken('Access Token')->accessToken;

        return [
            'token' => $token,
            'user' => $user
        ];
    }
}
