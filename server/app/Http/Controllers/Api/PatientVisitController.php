<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PatientVisit;

class PatientVisitController extends Controller
{
    public function index()
    {
        return message('',PatientVisit::all());
    }

    public function show(PatientVisit $patientVisit)
    {
        return message('',$patientVisit);
    }

    public function store(Request $request)
    {

        $patientVisit=PatientVisit::create($request->all());

        return message('',$patientVisit);
    }

    public function update(Request $request ,PatientVisit $patientVisit)
    {
        $patientVisit->update($request->all());

        return message('',$patientVisit, 200);
    }

    public function delete(PatientVisit $patientVisit)
    {
        $patientVisit->delete();

        return message('',null, 200);
    }
}
