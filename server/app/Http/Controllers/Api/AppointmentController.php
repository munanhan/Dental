<?php

namespace App\Http\Controllers\Api;

use App\Model\Patient;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Appointment;

class AppointmentController extends Controller
{
    //
    public function addAppointment(Request $request){
        $data=$request->all();

        $patientArray = ['name'=>'','age'=>'','sex'=>'','phone'=>'','case_id'=>'','content'=>''];


        $patientData = array_intersect_key($data,$patientArray);
        $data = array_diff_key($data,$patientArray);


        $patient=$this->createPatient($patientData);

        $data['patient_id'] = $patient->id;
     

        $data['over_time'] = str_replace(substr($data['start_time'],0,2),
            (substr($data['start_time'],0,2)+1),$data['start_time']);


        $this->createAppointment($patient,$data);

       return message('预约成功','',200);
    }
    public function getTodayAppointment(){
//       $where =$date ? $date: date("Y-m-d");
        $where =  \request('date')?request('date'):date('Y-m-d');
       $appoinment =new Appointment();
       $res =$appoinment->where('appointment_date',$where)->leftJoin('patients','appointments.patient_id','=','patients.id')->
       get(['appointments.*','patients.name','patients.age','patients.case_id','patients.sex','patients.phone','patients.content']);

        return message('获取成功',$res,200);

    }
    public function getByIdAppointment(){
//        $res =Appointment::find(\request('id'));
        $appoinment =new Appointment();
        $res =$appoinment->where('appointments.id',\request('id'))->leftJoin('patients','appointments.patient_id','=','patients.id')->
        first(['appointments.*','patients.name','patients.age','patients.case_id','patients.sex','patients.phone','patients.content']);

        return message('获取成功',$res,200);
    }

    public function store(Request $request)
    {
        $data=$request->all();
//        dd($data);
//        $patient=$this->createPatient($data);
//       $this->createAppointment($patient,$data);

    }
     public function createAppointment(Patient $patient,array $data)
     {
         return $patient->appointment()->create($data);
     }

     public function createPatient(array $data)
     {
         return Patient::create($data);
     }
}
