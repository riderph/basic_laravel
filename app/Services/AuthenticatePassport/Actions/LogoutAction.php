<?php

namespace App\Services\AuthenticatePassport\Actions;

use App\Services\Action;

class LogoutAction extends Action
{

    /**
     * Execute action
     *
     * @return void
     */
    public function run()
    {
        auth()->logout();
    }
}
