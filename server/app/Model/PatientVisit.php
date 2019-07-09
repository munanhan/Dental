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

    public function getStatusAttribute($value)
    {
        $status=[
            0=>'已访',
            1=>'未访',
            2=>'待跟进',
        ];
        return $status[$value];
    }

    public function getAttendDoctorAttribute($value)
    {
        $user=User::find($value);
        return $user->name;
    }

    public function getReviewStaffAttribute($value)
    {
        $user=User::find($value);
        return $user->name;
    }
}
