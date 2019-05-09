<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{

    protected  $fillable=[
        'name','contact','phone'
    ];

    public function users()
    {
        return $this->hasMany('App\Model\User');
    }

    public function Company()
    {
        return $this->belongsTo('App\Model\Company');
    }
}
