<?php

namespace App\Model;

use App\Events\CreatingEvent;
use App\Events\UpdatingEvent;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $guarded=['id',];

    protected $dispatchesEvents=[
        'creating'=>CreatingEvent::class,
        'updating'=>UpdatingEvent::class,
    ];

    public function patientInfo()
    {
        return $this->hasOne(PatientInfo::class);
    }


    public function appointment()
    {
        return $this->hasMany(Appointment::class);
    }

}
