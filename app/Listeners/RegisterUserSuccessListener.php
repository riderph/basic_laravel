<?php

namespace App\Listeners;

use App\Events\Event;
use App\Events\RegisterUserSuccessEvent;
use App\Mail\RegisterUserSuccessEmail;

class RegisterUserSuccessListener extends Event
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //Todo
    }

    /**
     * Handle the event.
     *
     * @param RegisterUserSuccessEvent $event RegisterUserSuccessEvent
     *
     * @return void
     */
    public function handle(RegisterUserSuccessEvent $event)
    {
        $user = $event->user;
        // create data ...
        // handle event ...
        // send mail
        dispatch(new RegisterUserSuccessEmail($user->email, $user->name));
    }
}
