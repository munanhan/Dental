<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $guarded=['id',];

    public function patientInfo()
    {
        return $this->hasOne(PatientInfo::class);
    }
}
