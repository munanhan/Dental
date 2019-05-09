<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PatientImpression;

class PatientImpressionController extends Controller
{
    public function index()
    {
        return message('',PatientImpression::all());
    }

    public function show(PatientImpression $patientImpression)
    {
        return message('',$patientImpression);
    }

    public function store(Request $request)
    {

        $patientImpression=PatientImpression::create($request->all());

        return message('',$patientImpression);
    }

    public function update(Request $request ,PatientImpression $patientImpression)
    {
        $patientImpression->update($request->all());

        return message('',$patientImpression, 200);
    }

    public function delete(PatientImpression $patientImpression)
    {
        $patientImpression->delete();

        return message('',null, 200);
    }
}
