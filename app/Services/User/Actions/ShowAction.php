<?php

namespace App\Services\User\Actions;

use App\Models\User;
use App\Notifications\DeleteUserNotification;
use App\Services\Action;

class ShowAction extends Action
{

    /**
     * Execute action
     *
     * @param int $id Id of user need to delete
     *
     * @return mixed
     */
    public function run(int $id)
    {
        return User::findOrFail($id, ['id', 'name', 'email', 'created_at']);
    }
}
