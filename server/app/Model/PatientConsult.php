<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PatientConsult extends Model
{
    protected $guarded=['id'];

//    public function getBaseDemandAttribute($value)
//    {
//        return explode(',',$value);
//    }

//    public function getPotentialDemandAttribute($value)
//    {
//        return explode(',',$value);
//    }

    public function setPotentialDemandAttribute($value)
    {
        $this->attributes['potential_demand']=implode(',',$value);
    }

    public function setBaseDemandAttribute($value)
    {
        $this->attributes['base_demand']=implode(',',$value);
    }
}
