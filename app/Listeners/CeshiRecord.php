<?php

namespace App\Listeners;

use App\Events\Ceshi;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CeshiRecord
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Ceshi  $event
     * @return void
     */
    public function handle(Ceshi $event)
    {
        //
    }
}
