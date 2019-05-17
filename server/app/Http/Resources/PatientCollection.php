<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PatientCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'patient_members'=>PatientMember::collection(\App\Model\PatientMember::all()),
            'patient_professions'=>PatientProfession::collection(\App\Model\PatientProfession::all()),
            'patient_impressions'=>PatientImpression::collection(\App\Model\PatientImpression::all()),
            'patient_sources'=>PatientSource::collection(\App\Model\PatientSource::all()),
            'patient_categories'=>PatientCategory::collection(\App\Model\PatientCategory::all()),
            'patient_allergies'=>PatientAllergy::collection(\App\Model\PatientAllergy::all()),
            'patient_anamneses'=>PatientAnamnesis::collection(\App\Model\PatientAnamnesis::all()),
            'patient_teeth_habits'=>PatientTeethHabit::collection(\App\Model\PatientTeethHabit::all()),
            'users'=>[
                'all'=>User::collection(\App\Model\User::all()),
                'doctor'=>User::collection(\App\Model\User::whereHas('roles',function($query){
                    $query->whereIn('roles.id',[2,3,8]);
                })->get()),
                'consult'=>User::collection(\App\Model\User::whereHas('roles',function($query){
                    $query->where('roles.id',3);
                })->get()),
            ],
        ];
    }


}
