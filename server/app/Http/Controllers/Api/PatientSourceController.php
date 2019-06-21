<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PatientSource;

class PatientSourceController extends Controller
{
    public function index()
    {
        return message('',PatientSource::all());
    }

    public function show(PatientSource $patientSource)
    {
        return message('',$patientSource);
    }

    public function store(Request $request)
    {
        $patientSource=PatientSource::find(request('id'));

        if($patientSource){
            $patientSource->name=request('name');
            $patientSource->save();
        }else{
            $patientSource=PatientSource::create($request->all());
        }

        return message('',$patientSource);
    }

    public function update(Request $request ,PatientSource $patientSource)
    {
        $patientSource->update($request->all());

        return message('',$patientSource, 200);
    }

    public function delete(PatientSource $patientSource)
    {

        $patientSource->delete();

        return message('',$patientSource, 200);
    }
}
