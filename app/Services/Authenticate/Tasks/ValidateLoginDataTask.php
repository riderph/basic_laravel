<?php

namespace App\Services\Authenticate\Tasks;

use App\Exceptions\ValidatorException;
use App\Services\Task;

class ValidateLoginDataTask extends Task
{

    /**
     * Execute action
     *
     * @param array $credentials App type
     *
     * @return mixed
     *
     * @throws ValidatorException
     */
    public function run(array $credentials)
    {
        $data = trim_without_array($credentials, ['password']);

        $this->validateData($data);

        return $data;
    }

    /**
     * Validate data.
     *
     * @param array $data Data validate
     *
     * @return void
     *
     * @throws ValidatorException
     */
    private function validateData(array $data)
    {
        $validator = app('validator')->make(
            $data,
            $this->getRules()
        );

        if ($validator->fails()) {
            throw new ValidatorException($validator->errors());
        }
    }

    /**
     * Validate data.
     *
     * @return array
     */
    private function getRules()
    {
        return [
            'email' => 'required|email|max:255|exists:users,email',
            'password' => 'required|min:1|max:255',
        ];
    }
}
