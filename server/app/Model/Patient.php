<?php

namespace App\Model;

use App\Events\CreatingEvent;
use App\Events\RecordEvent;
use App\Events\UpdatingEvent;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $guarded=['id',];

    protected $dispatchesEvents=[
        'creating'=>CreatingEvent::class,
        'updating'=>UpdatingEvent::class,
        'retrieved'=>RecordEvent::class,
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function patientCases()
    {
        return $this->hasMany(PatientCase::class);
    }

    public function patientVisit()
    {
        return $this->hasMany(PatientVisit::class);
    }

}
