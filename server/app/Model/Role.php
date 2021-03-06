<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\Model\User','role_users');
    }

    public function privileges()
    {
        return $this->belongsToMany('App\Model\Privilege');
    }
}
