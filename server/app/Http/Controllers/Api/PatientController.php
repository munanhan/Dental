<?php

namespace App\Http\Controllers\Api;

use App\Model\Appointment;
use App\Model\Patient;
use App\Model\PatientInfo;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    const SERIAL_NUMBER="serial.number:";

    const DEFAULT_LENGTH=3;

    public function show()
    {
        $id=request('id');
        $data= Patient::where('id',$id)->first();
        $appOld=Appointment::where('patient_id',$id)->oldest()->first();
        $data['first_date']=$appOld->appointment_date;
        $data['first_doctor']=$appOld->appointment_doctor;
        $appNew=Appointment::where('patient_id',$id)->latest()->first();
        $data['last_date']=$appNew->appointment_date;
        $data['last_doctor']=$appNew->appointment_doctor;
        return message('',$data,200);
    }

    public function store(Request $request)
    {
        $patient=$request->all();

        $appointment['type']=$patient['diagnose_status'];
        $appointment['appointment_date']=$patient['treatment_date'];
        $appointment['appointment_doctor']=$patient['attend_doctor'];

        $exclude=['diagnose_status','treatment_date','attend_doctor'];
        foreach ($exclude as $key){
            if(array_key_exists($key,$patient)){
                unset($patient[$key]);
            }
        }

        $patientModel=Patient::where(['patient_phone'=>$patient['patient_phone']])->first();
        if($patientModel){
            if(Appointment::where(['patient_id'=>$patientModel->id,
                'treatment_date'=>$appointment['appointment_date'],
                'attend_doctor'=>$appointment['appointment_doctor']])){
                return message('该医生今天已经接诊过该患者，请更换医生或日期！','',400);
            }else{
                Patient::where('patient_phone',$patient['patient_phone'])->update($patient);
                $appointment['patient_id']=$patientModel->id;
                $appointment['flag']=0;
                $appointment['status']=2;
                if(Appointment::create($appointment)){
                    return message('添加成功','',200);
                }
            }
        }else{
            $patientModel=Patient::create($patient);
            $appointment['patient_id']=$patientModel->id;
            $appointment['flag']=0;
            $appointment['status']=2;
            if(Appointment::create($appointment)){
                return message('添加成功','',200);
            }
        }

    }

    public function searchByName()
    {
        $patient_name=request('patient_name');
        $patient=Patient::where('patient_name','like','%'.$patient_name.'%')->get();
        return message('',$patient,200);
    }

    public function update(Request $request)
    {
        $patient=$request->all();
        $id=$patient['id'];
        $appOld=Appointment::where('patient_id',$id)->oldest()->first();
        $appOld->appointment_date=$patient['first_date'];
        $appOld->appointment_doctor=$patient['first_doctor'];
        $appOld->save();
        $appNew=Appointment::where('patient_id',$id)->latest()->first();
        $appNew->appointment_date=$patient['last_date'];
        $appNew->appointment_doctor=$patient['last_doctor'];
        $appNew->save();
        $exclude=['first_doctor','first_date','last_doctor','last_date'];
        foreach ($exclude as $key){
            if(array_key_exists($key,$patient)){
                unset($patient[$key]);
            }
        }
        Patient::where('id',$id)->update($patient);

        return message('',$request->all(), 200);
    }

    public function delete(Request $request)
    {
        $id=$request->all('id');
        $patient=Patient::find($id);
        $patient->delete();
        return message('',null, 200);
    }


    /*
     * 今日工作
     */
    public function todayWork()
    {
        $whereTime=now()->toDateString();
        DB::connection()->enableQueryLog();
        $this->diagnose($whereTime,0,0,0,2);
        $queries=DB::getQueryLog();
        dd($queries);
        //$whereTime=now()->toDateString();
        //return $this->appointmentNotArrive($whereTime);
       // return $this->diagnose($whereTime,0,1,1,2);
        //return $this->diagnose($whereTime,0,0,0,2);


    }


    /*
     * 预约未到
     */
    public function appointmentNotArrive($whereTime)
    {
        return Patient::whereHas('appointments',function($query) use ($whereTime){
            $query
                ->where('appointments.appointment_date',$whereTime)
                ->where('appointments.deleted_at','=',null)
                ->whereNotIn('appointments.status',[2,3]);
        })->get();
    }

    /*
     * 今日初诊
     */
    public function todayFirstVisit($whereTime)
    {
        return $this->diagnose($whereTime,0);
    }

    /*
     * 今日复诊
     */
    public function todaySubsequentVisit($whereTime)
    {
        return $this->diagnose($whereTime,1);
    }


    /*
     * 返回初诊或者复诊患者
     */
    protected function firstOrSubsequent($whereTime,$patientType,$patientStatus)
    {
        return
            Patient::where('treatment_date',$whereTime)
                ->where('patient_type',$patientType)
                ->where('patient_status',$patientStatus);
            //->get();
    }


    /*
     * 患者诊断
     */
    protected function diagnose($whereTime,$patientType,$patientStatus,$appointmentType,$appointmentStatus)
    {

        $first=$this->firstOrSubsequent($whereTime,$patientType,$patientStatus);
        return Patient::whereHas('appointments',function ($query)
        use($whereTime,$appointmentType,$appointmentStatus) {
            $query
                ->where('appointments.type',$appointmentType)
                ->where('appointments.status',$appointmentStatus)
                ->where('appointments.appointment_date',$whereTime)
                ->whereNull('appointments.deleted_at');
        })->union($first)->get();
    }


    public function testUnion($whereTime)
    {
        return DB::table('patients')->where(['patient_type'=>0,'patient_status'=>0,'treatment_date'=>$whereTime])->select();
    }


    /*
     * 获取主治医生
     */
    public function attendDoctor()
    {
        $user=Auth::user();
        if($user->is_admin==1){
            return message('',$this->getUserByRoleId([1,2,3,8],$user->clinic_id));
        }else{
            return message(Auth::user());
        }
    }

    /*
     * 根据角色和诊所获取医生
     */
    protected function getUserByRoleId(Array $roles,$clinicId)
    {
        return Auth::user()->whereHas('roles',function ($query)use($roles,$clinicId){
            $query->whereIn('roles.id',$roles)->where('clinic_id',$clinicId);
        })->get();
    }

    protected  function getToday()
    {
        return now()->format('Ymd');
    }

    /*
     * 获取病历号
     */
    protected  function getCaseNumber()
    {

        $date=$this->getToday();

        $key=self::SERIAL_NUMBER.$date;

        $sequence=Redis::incr($key);

        $seq=$this->getSequence($sequence);

        $serial['case_id']=$date.$seq;

        return message('',$serial);

    }

    protected function getSequence($seq)
    {
        $len=mb_strlen($seq);

        if($len>=self::DEFAULT_LENGTH){
            return $seq;
        }

        $rest=self::DEFAULT_LENGTH-$len;

        for($i=0;$i<$rest;$i++){
            $seq='0'.$seq;
        }

        return $seq;
    }


}
