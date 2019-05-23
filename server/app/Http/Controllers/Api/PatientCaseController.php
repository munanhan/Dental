<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PatientCase;

class PatientCaseController extends Controller
{
    public function index()
    {
        return message('',PatientCase::all());
    }

    public function show(PatientCase $patientCase)
    {
        return message('',$patientCase);
    }

    public function store(Request $request)
    {
        //$data=$request->all();
        $data=[
            'status'=>'0',
            'doctor'=>'chan',
            'nurse'=>'zhu',
            'treatment_date'=>'2019-5-21',
            'main_complain'=>'主诉',
            'now_history'=>'11',
            'previous_history'=>'22',
            'allergy_history'=>'33',
            'doctor_advice'=>'44',
            'case_info'=>[
                ['type'=>1,'left_top'=>'12','left_bottom'=>'3','right_top'=>'4','right_bottom'=>'5','description'=>'12'],
                ['type'=>1,'left_top'=>'12','left_bottom'=>'3','right_top'=>'4','right_bottom'=>'5','description'=>'dd1212'],
                ['type'=>2,'left_top'=>'d','left_bottom'=>'a','right_top'=>'b','right_bottom'=>'c','description'=>'23'],
                ['type'=>3,'left_top'=>'2a','left_bottom'=>'2d','right_top'=>'1','right_bottom'=>'2','description'=>'34'],
                ['type'=>4,'left_top'=>'','left_bottom'=>'','right_top'=>'','right_bottom'=>'','description'=>'45'],
                ['type'=>5,'left_top'=>'','left_bottom'=>'','right_top'=>'','right_bottom'=>'','description'=>'56'],
            ]
        ];

        $patientCase=$this->createPatientCase($data);

        PatientCaseInfoController::createCaseInfo($patientCase,$data['case_info']);

        return message('',$data);
    }

    public function update(Request $request ,PatientCase $patientCase)
    {
        $patientCase->update($request->all());

        return message('',$patientCase, 200);
    }

    public function delete(PatientCase $patientCase)
    {
        $patientCase->delete();

        return message('',null, 200);
    }

    public function createPatientCase(array $data)
    {
        if(array_key_exists('case_info',$data)){
            unset($data['case_info']);
        }

        return PatientCase::create($data);
    }
}
