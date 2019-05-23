<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PatientCaseInfo extends Model
{
    protected $guarded=[
        'id',
        'patient_case_id',
        ];

    public function patientCase()
    {
        $this->belongsTo(PatientCase::class);
    }
}
