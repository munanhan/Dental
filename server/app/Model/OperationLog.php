<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Events\CreatingEvent;
use App\Events\UpdatingEvent;

class OperationLog extends Model
{
    protected $fillable = ['ct_user','patient','module'];

    protected $dispatchesEvents = [
		'creating' => CreatingEvent::class,
		'updating' => UpdatingEvent::class,
	];
}
