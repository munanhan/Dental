<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\AttendDoctor;
use App\Model\Role;
use Illuminate\Http\Request;
use App\Model\PatientConsult;

class PatientConsultController extends BaseController
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

    public function update()
    {
        $patientConsult=PatientConsult::where($this->parms['id'])->update($this->parms);

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
