<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PatientMember;

class PatientMemberController extends Controller
{
    public function index()
    {
        return message('',PatientMember::all());
    }

    public function show(PatientMember $patientMember)
    {
        return message('',$patientMember);
    }

    public function store(Request $request)
    {

        $patientMember=PatientMember::create($request->all());

        return message('',$patientMember);
    }

    public function update(Request $request ,PatientMember $patientMember)
    {
        $patientMember->update($request->all());

        return message('',$patientMember, 200);
    }

    public function delete(PatientMember $patientMember)
    {
        $patientMember->delete();

        return message('',null, 200);
    }
}
