<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Model\PatientCase;

class PatientCaseController extends BaseController
{

    public function show()
    {
        return '111';
    }

    public function store(Request $request)
    {
        $data=$request->all();

        $patientCase=$this->createPatientCase($data);

        $data['case_info']['patient_id']=$patientCase->id;

        PatientCaseInfoController::createCaseInfo($patientCase,$data['case_info']);

        return message('',$data);
    }


    public function createPatientCase(array $data)
    {
        if(array_key_exists('case_info',$data)){
            unset($data['case_info']);
        }

        return PatientCase::create($data);
    }
}
