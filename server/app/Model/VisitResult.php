<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VisitResult extends Model
{
    protected $guarded=['id',];
    protected $dispatchesEvents=[
        'creating'=>'App\Events\CreatingEvent',
        'updating'=>'App\Events\UpdatingEvent',
    ];
}
