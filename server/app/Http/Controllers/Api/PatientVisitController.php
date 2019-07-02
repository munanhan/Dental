<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\AttendDoctor;
use Illuminate\Http\Request;

use App\Model\PatientVisit;

class PatientVisitController extends BaseController
{
    use AttendDoctor;

    public function store(Request $request)
    {

        $patientVisit=PatientVisit::create($request->all());

        return message('',$patientVisit);
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

}
