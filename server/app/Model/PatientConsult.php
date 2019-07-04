<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function getPotentialDemandAttribute($value)
    {
        if(empty($value)){
           return $this->attributes['potential_demand']="";
        }
        $potential=DB::table('potential_demands')
            ->selectRaw('GROUP_CONCAT(name) as potential')
            ->whereRaw("id IN ($value)")
            ->get()
            ->toArray();

        $potential=json_decode(json_encode($potential,321) ,true);


        return $this->attributes['potential_demand']= $potential[0]['potential'];
    }

    public function getBaseDemandAttribute($value)
    {
        if(empty($value)){
            return $this->attributes['base_demand']="";
        }
        $base=DB::table('base_demands')
            ->selectRaw('GROUP_CONCAT(name) as base')
            ->whereRaw("id IN ($value)")
            ->get()
            ->toArray();

        $base=json_decode(json_encode($base,321) ,true);

        return $this->attributes['base_demand']=$base[0]['base'];
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
