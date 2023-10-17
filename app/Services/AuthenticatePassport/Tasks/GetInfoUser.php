<?php

namespace App\Services\AuthenticatePassport\Tasks;

use App\Models\User;
use App\Services\Task;

class GetInfoUser extends Task
{

    /**
     * Execute task
     *
     * @param array $conditions
     *
     * @return mixed
     *
     */
    public function run(array $conditions): mixed
    {
        return User::where($conditions)->first(['id', 'name', 'email', 'provider', 'provider_id']);
    }
}
