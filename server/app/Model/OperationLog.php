<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OperationLog extends Model
{
    protected $fillable = ['ct_user','patient','module'];
}
