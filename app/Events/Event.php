<?php

namespace App\Events;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class Event implements ShouldQueue
{
    use InteractsWithQueue,
        Queueable,
        SerializesModels;
}
