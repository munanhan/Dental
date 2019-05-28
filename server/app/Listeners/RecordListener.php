<?php

namespace App\Listeners;

use App\Events\RecordEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class RecordListener
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
     * @param  RecordEvent  $event
     * @return void
     */
    public function handle(RecordEvent $event)
    {
        Redis::sadd('recent_visit_id:'.$this->getCurrentUserId(),$event->patient->id);
    }

    public function getCurrentUserId()
    {
        return Auth::id();
    }
}
