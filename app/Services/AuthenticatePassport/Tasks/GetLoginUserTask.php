<?php

namespace App\Services\AuthenticatePassport\Tasks;

use App\Exceptions\ForbiddenException;
use App\Services\Task;
use Exception;
use Illuminate\Support\Facades\Auth;

class GetLoginUserTask extends Task
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
    public function run(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            throw new ForbiddenException(trans('auth.failed')); 
        }

        return Auth::user();
    }
}
