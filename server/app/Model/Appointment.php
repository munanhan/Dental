<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
        protected $guarded=['id',];

        public function patient()
        {
            $this->belongsTo(Patient::class);
        }
}
