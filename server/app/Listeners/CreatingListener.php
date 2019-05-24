<?php

namespace App\Listeners;

use App\Events\CreatingEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;


class CreatingListener
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
     * @param  CreatingEvent  $event
     * @return void
     */
    public function handle(CreatingEvent $event)
    {
        $event->model->fill(['created_by'=>Auth::user()->name]);
    }
}
