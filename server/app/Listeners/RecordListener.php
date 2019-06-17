<?php

namespace App\Listeners;

use App\Events\RecordEvent;
use App\Model\RecentVisit;
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
        RecentVisit::create(['user_id'=>Auth::id(),'patient_id'=>$event->patient->id]);
    }

}
