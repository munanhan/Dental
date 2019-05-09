<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PatientProfession;

class PatientProfessionController extends Controller
{
    public function index()
    {
        return message('',PatientProfession::all());
    }

    public function show(PatientProfession $patientProfession)
    {
        return message('',$patientProfession);
    }

    public function store(Request $request)
    {

        $patientProfession=PatientProfession::create($request->all());

        return message('',$patientProfession);
    }

    public function update(Request $request ,PatientProfession $patientProfession)
    {
        $patientProfession->update($request->all());

        return message('',$patientProfession, 200);
    }

    public function delete(PatientProfession $patientProfession)
    {
        $patientProfession->delete();

        return message('',null, 200);
    }
}
