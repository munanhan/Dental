<?php

namespace App\Http\Controllers\Api;

use App\Model\Patient;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Appointment;

class AppointmentController extends Controller
{
    //修改预约状态
    public function changeAppointmentStatus(Request $request){
        $data=$request->all();
        Appointment::where('id',$data['id'])->update(['status'=>$data['status']]);
        return  message('修改成功','',200);
    }
    //添加预约和修改预约
    public function addAppointment(Request $request){
        $data=$request->all();
        $patientArray = ['patient_name'=>'','patient_age'=>'','patient_sex'=>'','patient_phone'=>'','case_id'=>'','patient_content'=>'','patient_source'=>''];
        $patientData = array_intersect_key($data,$patientArray);
        $data = array_diff_key($data,$patientArray);
        $patientData['patient_type'] = '1';
        // $data['id'] 存在即修改
        if(isset($data['id'])){
            $id = $data['id'];
            unset($data['id']);
            $patient_id = $data['patient_id'];
            Appointment::where('id',$id)->update($data);
            Patient::where('id',$patient_id)->update($patientData);
            return  message('修改预约成功','',200);
        }

//        $patient=$this->createPatient($patientData);
        $patient=Patient::create($patientData);

        $data['patient_id'] = $patient->id;
        $data['over_time'] = str_replace(substr($data['start_time'],0,2),
            (substr($data['start_time'],0,2)+1),$data['start_time']);
       Appointment::create($data);

       return message('新增预约成功','',200);
    }
    //获得今天或某天的数据
    public function getTodayAppointment(){

        $where =  \request('date')?request('date'):date('Y-m-d');
       $appoinment =new Appointment();
       $res =$appoinment->where('appointment_date',$where)->leftJoin('patients','appointments.patient_id','=','patients.id')->
       get(['appointments.*','patients.patient_name','patients.patient_age','patients.case_id','patients.patient_sex','patients.patient_phone','patients.patient_content','patients.patient_source']);

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
        get(['appointments.*','patients.patient_name','patients.patient_age','patients.case_id','patients.patient_sex','patients.patient_phone','patients.patient_content','patients.patient_source']);

        return message('获取成功',$res,200);
    }
    public function getListAppointment(Request $request){
        $data=$request->all();
        if($data['dtfm'] > $data['dtto']){
            $start = $data['dtto'];
            $end = $data['dtfm'];
        }else{
            $end = $data['dtto'];
            $start = $data['dtfm'];
        }
        $appoinment =new Appointment();
        if($data['statusRadio'] == '全部'){
            $res =$appoinment->where('appointment_date','>=',$start)->where('appointment_date','<=',$end)->leftJoin('patients','appointments.patient_id','=','patients.id')->
            get(['appointments.*','patients.patient_name','patients.patient_age','patients.case_id','patients.patient_sex','patients.patient_phone','patients.patient_content','patients.patient_source']);

        }else{
            $res =$appoinment->where('appointment_date','>=',$start)->where('appointment_date','<=',$end)->where('status',$data['statusRadio'])
                ->leftJoin('patients','appointments.patient_id','=','patients.id')->
                get(['appointments.*','patients.patient_name','patients.patient_age','patients.case_id','patients.patient_sex','patients.patient_phone','patients.patient_content','patients.patient_source']);

        }


        return message('获取成功',$res,200);
    }
    //获取某个月的数据
    public function getMonthAppointment(Request $request){
        $data=$request->all();
        $startMonth = $data['start'];
        $endMonth = $data['end'];
        $appoinment =new Appointment();

        $now = explode(" ", date("Y-m-d H:i:s"));
        Appointment::where('status','0')->where('appointment_date','<',$now[0])->update(['status'=>3]);
        Appointment::where('status','0')->where('appointment_date','=',$now[0])->where('over_time','<=',$now[1])->update(['status'=>3]);
        $res =$appoinment->where('appointment_date','>=',$startMonth)->where('appointment_date','<=',$endMonth)->leftJoin('patients','appointments.patient_id','=','patients.id')->
        get(['appointments.*','patients.patient_name','patients.patient_age','patients.case_id','patients.patient_sex','patients.patient_phone','patients.patient_content','patients.patient_source']);

        return message('获取成功',$res,200);
    }
    public function getByIdAppointment(){
//        $res =Appointment::find(\request('id'));
        $appoinment =new Appointment();
        $res =$appoinment->where('appointments.id',\request('id'))->leftJoin('patients','appointments.patient_id','=','patients.id')->
        first(['appointments.*','patients.patient_name','patients.patient_age','patients.case_id','patients.patient_sex','patients.patient_phone','patients.patient_content','patients.patient_source']);

        return message('获取成功',$res,200);
    }


}
