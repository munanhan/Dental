<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PatientCase;

class PatientCaseController extends Controller
{
    public function index()
    {
        return message('',PatientCase::all());
    }

    public function show(PatientCase $patientCase)
    {
        return message('',$patientCase);
    }

    public function store(Request $request)
    {

        $patientCase=PatientCase::create($request->all());

        return message('',$patientCase);
    }

    public function update(Request $request ,PatientCase $patientCase)
    {
        $patientCase->update($request->all());

        return message('',$patientCase, 200);
    }

    public function delete(PatientCase $patientCase)
    {
        $patientCase->delete();

        return message('',null, 200);
    }
}
