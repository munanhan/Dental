<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\AttendDoctor;
use App\Http\Controllers\Traits\PatientBaseInfo;
use App\Model\BaseDemand;
use App\Model\PatientConsult;
use App\Model\PotentialDemand;
use App\Model\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientConsultController extends BaseController
{

    use AttendDoctor,PatientBaseInfo;


    public function show()
    {
        $data=PatientConsult::where('patient_id',request('id'))->get();
        return message('',$data,200);
    }

    /*
     * 默认资料录入人
     */
    public function defaultRecorder()
    {
        $data=Auth::user()->id;
        return message('',$data,200);
    }

    public function store(Request $request)
    {

        $patientConsult=PatientConsult::create($request->all());

        return message('添加成功',$patientConsult,200);
    }

    public function update()
    {
        $data=request()->all();
        PatientConsult::where('id',$data['id'])->update($data);

        $data=PatientConsult::where('id',$data['id'])->get();
//        $patientConsult=PatientConsult::find($data['id']);
//        $patientConsult->main_consult=$data['main_consult'];
//        $patientConsult->base_demand=$data['base_demand'];
//        $patientConsult->potential_demand=$data['potential_demand'];
//        $patientConsult->doctor_solution=$data['doctor_solution'];
//        $patientConsult->service_proposal=$data['service_proposal'];
//        $patientConsult->doctor=$data['doctor'];

        return message('',$data,200);


    }



    public function consultInfoList()
    {
        if(request('id'))
        {
            $this->parms['id']=request('id');
            $res=$this->getDataById();
            $res['base_demand']= $res['base_demand']? explode(',',$res['base_demand']) : [];
            $res['potential_demand']=$res['potential_demand']? explode(',',$res['potential_demand']) : [];
            $data['consultInfo']=$res;
        }
        $data['patientInfo']=$this->getPatientBaseInfo(request('patient_id'));

        $data['doctorInfo']=$this->getDoctorByRoleId(Role::all('id')->toArray());

        $data['baseDemand']=BaseDemand::all('id','name');

        $data['potentialDemand']=PotentialDemand::all('id','name');

        return message('',$data,200);

    }
}
