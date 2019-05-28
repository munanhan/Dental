<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PatientAllergy;

class PatientAllergyController extends Controller
{
    public function index()
    {
        return message('',PatientAllergy::all());
    }

    public function show(PatientAllergy $patientAllergy)
    {
        return message('',$patientAllergy);
    }

    public function store(Request $request)
    {

        $allergy=PatientAllergy::create($request->all());

        return message('',$allergy);
    }

    public function update(Request $request ,PatientAllergy $patientAllergy)
    {
        $patientAllergy->update($request->all());

        return message('',$patientAllergy, 200);
    }

    public function delete(PatientAllergy $patientAllergy)
    {
        $patientAllergy->delete();

        return message('',null, 200);
    }
}
