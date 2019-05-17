<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PatientConsultCollection extends ResourceCollection
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
            'base_demands'=>BaseDemand::collection(\App\Model\BaseDemand::all()),
            'potential_demands'=>PotentialDemand::collection(\App\Model\PotentialDemand::all()),
            'users'=>User::collection(\App\Model\User::all()),
        ];
    }
}