<?php

namespace App\Services\Authenticate\Actions;

use App\Services\Action;
use App\Services\Authenticate\Tasks\GetLoginUserTask;
use App\Services\Authenticate\Tasks\InvalidateOldTokenTask;
use App\Services\Authenticate\Tasks\ValidateLoginDataTask;
use Tymon\JWTAuth\JWTAuth;

class LoginAction extends Action
{

    /**
     * JWTAuth
     *
     * @var JWTAuth
     */
    protected $auth;

    /**
     * Constructor.
     *
     * @param JWTAuth $auth JWTAuth
     *
     * @return void
     */
    public function __construct(JWTAuth $auth) {
        $this->auth = $auth;
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
        resolve(InvalidateOldTokenTask::class)->run($this->auth);

        $data = resolve(ValidateLoginDataTask::class)->run($credentials);

        $user = resolve(GetLoginUserTask::class)->run($data);

        $token = $this->auth->fromUser($user);

        return [
            'token' => $token,
            'user' => $user
        ];
    }
}
