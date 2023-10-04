<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

abstract class Mailable implements ShouldQueue
{

    use InteractsWithQueue,
        Queueable,
        SerializesModels;
}
