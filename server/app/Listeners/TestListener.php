<?php

namespace App\Listeners;

use App\Events\TestEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class TestListener
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

    /***
     * @param TestEvent $event
     */
    public function handle(TestEvent $event)
    {
        $event->model->fill(['created_by'=>Auth::user()->name]);
    }
}
