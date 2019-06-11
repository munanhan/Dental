<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\AttendDoctor;
use App\Model\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PatientConsult;

class PatientConsultController extends Controller
{

    use AttendDoctor;

    public function index()
    {
        return message('',PatientConsult::all());
    }

    public function show(Request $request)
    {
        $id=$request->all('id');
        $patientConsult=PatientConsult::find($id);
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

    public function delete()
    {
        PatientConsult::destroy(request('id'));

        return message('',null, 200);
    }

    public function getDoctorOrRecorder()
    {
        return $this->getDoctorByRoleId(Role::all('id')->toArray());
    }
}
