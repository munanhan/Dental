<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PatientSource extends Model
{
    protected $fillable=[
        'name','created_at','created_by','updated_at','updated_by',
    ];
}
