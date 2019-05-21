<?php

namespace App\Http\Controllers\Api;

use App\Model\Patient;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Appointment;

class AppointmentController extends Controller
{
    //添加预约和修改预约
    public function addAppointment(Request $request){
        $data=$request->all();
        $patientArray = ['name'=>'','age'=>'','sex'=>'','phone'=>'','case_id'=>'','content'=>''];
        $patientData = array_intersect_key($data,$patientArray);
        $data = array_diff_key($data,$patientArray);
        // $data['id'] 存在即修改
        if(isset($data['id'])){
            $id = $data['id'];
            unset($data['id']);
            $patient_id = $data['patient_id'];
            Appointment::where('id',$id)->update($data);
            Patient::where('id',$patient_id)->update($patientData);
            return  message('修改成功','',200);
        }

//        $patient=$this->createPatient($patientData);
        $patient=Patient::create($patientData);

        $data['patient_id'] = $patient->id;
        $data['over_time'] = str_replace(substr($data['start_time'],0,2),
            (substr($data['start_time'],0,2)+1),$data['start_time']);
        $this->createAppointment($patient,$data);

       return message('预约成功','',200);
    }
    //获得今天或某天的数据
    public function getTodayAppointment(){

        $where =  \request('date')?request('date'):date('Y-m-d');
       $appoinment =new Appointment();
       $res =$appoinment->where('appointment_date',$where)->leftJoin('patients','appointments.patient_id','=','patients.id')->
       get(['appointments.*','patients.name','patients.age','patients.case_id','patients.sex','patients.phone','patients.content']);

        return message('获取成功',$res,200);

    }
    //获得某个礼拜的数据
    public function getWeekAppointment(Request $request){
        $data=$request->all();
       $weekStart = preg_replace('/年|月|日/','-',$data['weekStart']);
        $weekStart =substr($weekStart,0,-1);
        $weekStart = preg_replace('/-(\d)-/','-0$1-',$weekStart);
        $weekEnd = preg_replace('/年|月|日/','-',$data['weekEnd']);
        $weekEnd =substr($weekEnd,0,-1);
        $weekEnd = preg_replace('/-(\d)-/','-0$1-',$weekEnd);
        $appoinment =new Appointment();
        $res =$appoinment->where('appointment_date','>=',$weekStart)->where('appointment_date','<=',$weekEnd)->leftJoin('patients','appointments.patient_id','=','patients.id')->
        get(['appointments.*','patients.name','patients.age','patients.case_id','patients.sex','patients.phone','patients.content']);

        return message('获取成功',$res,200);
    }
    //获取某个月的数据
    public function getMonthAppointment(Request $request){
        $data=$request->all();
        $startMonth = $data['start'];
        $endMonth = $data['end'];
        $appoinment =new Appointment();
        $res =$appoinment->where('appointment_date','>=',$startMonth)->where('appointment_date','<=',$endMonth)->leftJoin('patients','appointments.patient_id','=','patients.id')->
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
