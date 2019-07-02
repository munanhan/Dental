<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\AttendDoctor;
use App\Http\Controllers\Traits\PatientBaseInfo;
use App\Model\PatientConsult;
use App\Model\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientConsultController extends BaseController
{

    use AttendDoctor,PatientBaseInfo;
    
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


    public function show()
    {
        $data=PatientConsult::where('patient_id','=',request('id'))->get();
        return message('',$data,200);
    }

    /*
     * 默认资料录入人
     */
    public function defaultRecorder()
    {
        $data=Auth::user()->name;
        return message('',$data,200);
    }

    public function store(Request $request)
    {

        $patientConsult=PatientConsult::create($request->all());

        return message('添加成功',$patientConsult,200);
    }

    public function update()
    {
        PatientConsult::where('id',request('id'))->update(request()->all());
    }

    public function patientInfo()
    {
        $data= $this->getPatientBaseInfo(request('id'));
        return message('',$data,200);
    }
}
