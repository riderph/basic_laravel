<?php

namespace App\Services\User\Actions;

use App\Models\User;
use App\Notifications\DeleteUserNotification;
use App\Services\Action;

class DeleteAction extends Action
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
        $user = User::findOrFail($id, ['id', 'name']);

        $user->notify(new DeleteUserNotification());

        return $user->delete();
    }
}
