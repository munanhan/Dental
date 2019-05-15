<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
        protected $guarded=['id',];
        public function patient()
         {
             return $this->hasOne(Patient::class,'patient_id','id');
         }

}
