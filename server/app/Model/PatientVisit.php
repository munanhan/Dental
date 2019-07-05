<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PatientVisit extends Model
{
    protected $guarded=['id'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
