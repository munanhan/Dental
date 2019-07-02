<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\AttendDoctor;
use App\Http\Controllers\Traits\PatientBaseInfo;
use Illuminate\Http\Request;

use App\Model\PatientVisit;

class PatientVisitController extends BaseController
{
    use AttendDoctor,PatientBaseInfo;

    public function store(Request $request)
    {

        $patientVisit=PatientVisit::create($request->all());

        return message('',$patientVisit);
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

    public function patientInfo()
    {
        $data= $this->getPatientBaseInfo(request('id'));
        return message('',$data,200);
    }

}
