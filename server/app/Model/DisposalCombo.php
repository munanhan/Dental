<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Events\CreatingEvent;
use App\Events\UpdatingEvent;

class DisposalCombo extends Model
{
    protected $guarded = [
            'id',
        ];

    protected $dispatchesEvents = [
    		'creating' => CreatingEvent::class,
    		'updating' => UpdatingEvent::class,
    	];

    // public $timestamps = false;
}
