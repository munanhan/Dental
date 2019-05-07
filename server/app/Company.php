<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected  $fillable=[
        'name','contact','phone'
    ];

     public function clinics()
     {
         return $this->hasMany('App\Clinic');
     }
}
