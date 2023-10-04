<?php

namespace App\Events;

use App\Models\User;

class RegisterUserSuccessEvent extends Event
{

    /**
     * User
     *
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param User $user User
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
