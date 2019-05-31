<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PatientAllergy;

class PatientAllergyController extends BaseController
{
//    public function index()
//    {
//        return message('',PatientAllergy::all());
//    }

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

//    public function update(Request $request ,PatientAllergy $patientAllergy)
//    {
//        $patientAllergy->update($request->all());
//
//        return message('',$patientAllergy, 200);
//    }
//
//    public function delete(PatientAllergy $patientAllergy)
//    {
//        $patientAllergy->delete();
//
//        return message('',null, 200);
//    }
}
