<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PatientMember extends Model
{
    protected $fillable=[
        'name','discount',
    ];
}
