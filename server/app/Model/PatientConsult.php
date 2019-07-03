<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PatientConsult extends Model
{
    protected $guarded=['id'];



    public function setPotentialDemandAttribute($value)
    {
        $this->attributes['potential_demand']=implode(',',$value);
    }

    public function setBaseDemandAttribute($value)
    {
        $this->attributes['base_demand']=implode(',',$value);
    }

    public function getDoctorAttribute($value)
    {
        $user=User::find($value);
        return $this->attributes['potential_demand']=$user->name;
    }

    public function getDataEntryPersonAttribute($value)
    {
        $user=User::find($value);
        return $this->attributes['potential_demand']=$user->name;
    }
}
