<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PatientAnamnesis;

class PatientAnamnesisController extends BaseController
{
    public function index()
    {
        return message('',PatientAnamnesis::all());
    }

    public function show(PatientAnamnesis $patientAnamnesis)
    {
        return message('',$patientAnamnesis);
    }

    public function store(Request $request)
    {

        $patientAnamnesis= PatientAnamnesis::find(request('id'));

        if($patientAnamnesis){
            $patientAnamnesis->name=request('name');
            $patientAnamnesis->save();
        }else{
            $patientAnamnesis=PatientAnamnesis::create($request->all());
        }

        return message('',$patientAnamnesis);
    }

//    public function update(Request $request , PatientAnamnesis $patientAnamnesis)
//    {
//        $patientAnamnesis->update($request->all());
//
//        return message('',$patientAnamnesis, 200);
//    }
//
//    public function delete(PatientAnamnesis $patientAnamnesis)
//    {
//        $patientAnamnesis->delete();
//
//        return message('',null, 200);
//    }
}
