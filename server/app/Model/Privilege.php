<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    public function roles()
    {
        return $this->belongsToMany('App\Model\Role');
    }
}
