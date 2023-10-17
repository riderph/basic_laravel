<?php

namespace App\Services\AuthenticatePassport\Tasks;

use App\Models\User;
use App\Services\Task;

class CreateUserFromSocial extends Task
{

    /**
     * Execute task
     *
     * @param array $body
     *
     * @return mixed
     *
     */
    public function run(array $body)
    {
        return User::create($body);
    }
}
