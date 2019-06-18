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

    public function delete($id)
    {
        PatientAnamnesis::where('id',$id)->delete();

        return message('',null, 200);
    }
}
