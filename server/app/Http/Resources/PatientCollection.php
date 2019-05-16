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
            'patient_member'=>PatientMember::collection(\App\Model\PatientMember::all()),
            'patient_profession'=>PatientProfession::collection(\App\Model\PatientProfession::all()),
            'patient_impression'=>PatientImpression::collection(\App\Model\PatientImpression::all()),
            'patient_source'=>PatientSource::collection(\App\Model\PatientSource::all()),
            'patient_category'=>PatientCategory::collection(\App\Model\PatientCategory::all()),
            'patient_allergy'=>PatientAllergy::collection(\App\Model\PatientAllergy::all()),
            'patient_anamnesis'=>PatientAnamnesis::collection(\App\Model\PatientAnamnesis::all()),
            'patient_teeth_habit'=>PatientTeethHabit::collection(\App\Model\PatientTeethHabit::all()),
            'user'=>User::collection(\App\Model\User::all()),
        ];
    }
}
