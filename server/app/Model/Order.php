<?php

namespace App\Model;

use App\Events\TestEvent;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $dispatchesEvents=['saving'=>TestEvent::class];
}
