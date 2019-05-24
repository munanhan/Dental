<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PatientCase extends Model
{
    protected $guarded=[
      'id',
    ];

    public function caseInfos()
    {
        return $this->hasMany(PatientCaseInfo::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
