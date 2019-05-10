<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PatientConsult;

class PatientConsultController extends Controller
{
    public function index()
    {
        return message('',PatientConsult::all());
    }

    public function show(PatientConsult $patientConsult)
    {
        return message('',$patientConsult);
    }

    public function store(Request $request)
    {

        $patientConsult=PatientConsult::create($request->all());

        return message('',$patientConsult);
    }

    public function update(Request $request ,PatientConsult $patientConsult)
    {
        $patientConsult->update($request->all());

        return message('',$patientConsult, 200);
    }

    public function delete(PatientConsult $patientConsult)
    {
        $patientConsult->delete();

        return message('',null, 200);
    }
}
