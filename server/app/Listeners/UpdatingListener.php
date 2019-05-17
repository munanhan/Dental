<?php

namespace App\Listeners;

use App\Events\UpdatingEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class UpdatingListener
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
     * @param  UpdatingEvent  $event
     * @return void
     */
    public function handle(UpdatingEvent $event)
    {
        $event->model->fill(['updated_by'=>Auth::user()->name]);
    }
}
