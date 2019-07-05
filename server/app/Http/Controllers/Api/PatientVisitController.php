<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\AttendDoctor;
use App\Http\Controllers\Traits\PatientBaseInfo;
use App\Model\VisitContent;
use App\Model\VisitResult;
use Illuminate\Http\Request;

use App\Model\PatientVisit;

class PatientVisitController extends BaseController
{
    use AttendDoctor,PatientBaseInfo;

    public function store(Request $request)
    {

        $patientVisit=PatientVisit::create($request->all());

        return message('添加成功',$patientVisit,200);
    }

    public function show()
    {
        $data=PatientVisit::where('patient_id',request('id'))->get();
        return message('',$data,200);
    }

    /*
     * 获取回访人员
     */
    public function getVisitor()
    {
        return $this->getDoctorByRoleId([1,2,3,8,4,6]);
    }

    /*
     * 获取主治医生
     */
    public function getAttendDoctor()
    {
        return $this->getDoctorByRoleId([1,2,3,8]);
    }

    public function visitInfo(){
        $data['visitor']=$this->getVisitor();
        $data['attend_doctor']=$this->getAttendDoctor();
        $data['patient']=$this->patientInfo(request('id'));
        $data['visit_content']=$this->getVisitContent();
        $data['visit_result']=$this->getVisitResult();
        return message('',$data,200);
    }


    /*
     * 患者基本信息
     */
    public function patientInfo($id)
    {
        return $this->getPatientBaseInfo($id);
    }

    /*
     * 回访内容语
     */
    public function getVisitContent()
    {
        return VisitContent::all();
    }

    /*
     * 回访结束语
     */
    public function getVisitResult()
    {
        return VisitResult::all();
    }

}
