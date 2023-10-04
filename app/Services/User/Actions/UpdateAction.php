<?php

namespace App\Services\User\Actions;

use App\Models\User;
use App\Services\Action;

class UpdateAction extends Action
{

    /**
     * Execute action
     *
     * @param int   $id   Id of user
     * @param array $data Data
     *
     * @return mixed
     *
     * @throws \App\Exceptions\ValidatorException
     */
    public function run(int $id, array $data)
    {
        $user = User::findOrFail($id, ['id', 'name', 'email', 'created_at']);
        $user->name = $data['name'] ?? '';
        $user->email = $data['email'] ?? '';
        $user->save();

        return $user;
    }
}
