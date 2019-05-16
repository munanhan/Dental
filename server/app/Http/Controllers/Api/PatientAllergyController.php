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

    public function show(PatientAllergy $allergy)
    {
        return message('',$allergy);
    }

    public function store(Request $request)
    {

        $allergy=PatientAllergy::create($request->all());

        return message('',$allergy);
    }

    public function update(Request $request ,PatientAllergy $allergy)
    {
        $allergy->update($request->all());

        return message('',$allergy, 200);
    }

    public function delete(PatientAllergy $allergy)
    {
        $allergy->delete();

        return message('',null, 200);
    }
}
