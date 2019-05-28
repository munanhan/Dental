<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PatientAnamnesis;

class PatientAnamnesisController extends Controller
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

        $anamnesis=PatientAnamnesis::create($request->all());

        return message('',$anamnesis);
    }

    public function update(Request $request , PatientAnamnesis $patientAnamnesis)
    {
        $patientAnamnesis->update($request->all());

        return message('',$patientAnamnesis, 200);
    }

    public function delete(PatientAnamnesis $patientAnamnesis)
    {
        $patientAnamnesis->delete();

        return message('',null, 200);
    }
}
