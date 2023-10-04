<?php

namespace App\Services\Authenticate\Tasks;

use App\Services\Task;
use Tymon\JWTAuth\JWTAuth;

class InvalidateOldTokenTask extends Task
{

    /**
     * Get data when login successfully
     *
     * @return void
     */
    public function run(JWTAuth $auth)
    {
        if (!is_null($auth->user())) {
            $auth->invalidate();
        }
    }
}
