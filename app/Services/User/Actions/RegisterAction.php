<?php

namespace App\Services\User\Actions;

use App\Events\RegisterUserSuccessEvent;
use App\Exceptions\ValidatorException;
use App\Services\Action;
use App\Services\User\Tasks\CreateUserTask;
use Validator;

class RegisterAction extends Action
{

    /**
     * Execute action
     *
     * @param array $data Data
     *
     * @return mixed
     *
     * @throws \App\Exceptions\ValidatorException
     */
    public function run(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|min:6',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'password_confirm' => 'required|string|min:6|same:password',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException($validator->errors());
        }

        $user = resolve(CreateUserTask::class)->run($data);

        event(new RegisterUserSuccessEvent($user));

        return $user;
    }
}
