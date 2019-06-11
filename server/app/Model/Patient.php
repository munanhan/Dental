<?php

namespace App\Model;

use App\Events\CreatingEvent;
use App\Events\RecordEvent;
use App\Events\UpdatingEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{

    use SoftDeletes;
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

    public function setAllergyAttribute($value)
    {
        $this->attributes['allergy']=implode(',',$value);
    }

    public function getAllergyAttribute($value)
    {
        return explode(',',$value);
    }

    public function getAnamnesisAttribute($value)
    {
        return explode(',',$value);
    }

    public function setAnamnesisAttribute($value)
    {
        $this->attributes['anamnesis']= implode(',',$value);
    }

}
