<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\AttendDoctor;
use App\Model\Role;
use Illuminate\Http\Request;
use App\Model\PatientConsult;
use Illuminate\Support\Facades\Auth;

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

    public function delete($id)
    {
        PatientConsult::destroy($id);

        return message('',null, 200);
    }

    /*
     * 接着医生和资料录入人
     */
    public function getDoctorOrRecorder()
    {
        $user=Auth::user();
        if($user->is_admin==1){
            return $this->getDoctorByRoleId(Role::all('id')->toArray());
        }else{
            return $this->defaultRecorder();
        }

    }

    /*
     * 默认资料录入人
     */
    public function defaultRecorder()
    {
        $data=Auth::user()->name;
        return message('',$data,200);
    }
}
