<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PatientAllergy;

class PatientAllergyController extends BaseController
{

    public function show(PatientAllergy $patientAllergy)
    {
        return message('',$patientAllergy);
    }

    public function store(Request $request)
    {

        $patientAllergy= PatientAllergy::find(request('id'));

        if($patientAllergy){
            $patientAllergy->name=request('name');
            $patientAllergy->save();
        }else{
            $patientAllergy=PatientAllergy::create($request->all());
        }

        return message('',$patientAllergy);
    }

}
