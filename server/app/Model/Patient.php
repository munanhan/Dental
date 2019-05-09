<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
     protected  $fillable=[
         'name','sex','age','birthday','phone',
     ];
}
