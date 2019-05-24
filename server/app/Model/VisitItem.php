<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VisitItem extends Model
{
    protected $fillable=['name','days','created_by','updated_by'];

    protected $dispatchesEvents=[
        'creating'=>'App\Events\CreatingEvent',
        'updating'=>'App\Events\UpdatingEvent',
    ];
}
