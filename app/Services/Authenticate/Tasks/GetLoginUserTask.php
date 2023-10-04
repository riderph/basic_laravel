<?php

namespace App\Services\Authenticate\Tasks;

use App\Exceptions\ForbiddenException;
use App\Models\User;
use App\Services\Task;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;

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
        $user = User::where('email', $credentials['email'] ?? null)->first([
            'id',
            'name',
            'email',
            'password'
        ]);

        if (!Hash::check($credentials['password'] ?? '', $user->password)) {
            throw new ForbiddenException(trans('auth.failed'));
        }

        return $user;
    }
}
