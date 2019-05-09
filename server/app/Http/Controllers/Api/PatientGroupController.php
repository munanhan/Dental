<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PatientGroup;

class PatientGroupController extends Controller
{
    public function index()
    {
        return message('',PatientGroup::all());
    }

    public function show(PatientGroup $patientGroup)
    {
        return message('',$patientGroup);
    }

    public function store(Request $request)
    {

        $patientGroup=PatientGroup::create($request->all());

        return message('',$patientGroup);
    }

    public function update(Request $request , PatientGroup $patientGroup)
    {
        $patientGroup->update($request->all());

        return message('',$patientGroup, 200);
    }

    public function delete(PatientGroup $patientGroup)
    {
        $patientGroup->delete();

        return message('',null, 200);
    }
}
