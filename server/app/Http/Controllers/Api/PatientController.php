<?php

namespace App\Http\Controllers\Api;

use App\Model\Patient;
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

    public function index()
    {
        return message('',Patient::all());
    }

    public function show(Patient $patient)
    {
        return message('',$patient);
    }

    public function store(Request $request)
    {
        $patient=Patient::create($request->all());

        return message('',$patient);
    }

    public function update(Request $request ,Patient $patient)
    {
        $patient->update($request->all());

        return message('',$patient, 200);
    }

    public function delete(Patient $patient)
    {
        $patient->delete();

        return message('',null, 200);
    }


    /*
     * 今日工作
     */
    public function todayWork()
    {
        //DB::connection()->enableQueryLog();
        //$queries=DB::getQueryLog();
        //dd($queries);
//        $whereTime=request('date');
        $whereTime=now()->toDateString();

       // $appointment=$this->appointmentNotArrive($whereTime);

        $todayFirstVisit=$this->todayFirstVisit($whereTime);

        dd($todayFirstVisit);

        //$todaySubsequentVisit=$this->todaySubsequentVisit($whereTime);

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
        //$this->firstOrSubsequent($whereTime,0,0);

        return $this->diagnose($whereTime,2,1,0);

    }

    /*
     * 今日复诊
     */
    public function todaySubsequentVisit($whereTime)
    {
        $this->firstOrSubsequent($whereTime,0,1);

        $this->diagnose($whereTime,2,1,1);
    }


    /*
     * 返回初诊或者复诊患者
     */
    protected function firstOrSubsequent($whereTime,$patientType,$patientStatus)
    {
        return
            Patient::where('patient_type',$patientType)
            ->where('treatment_date',$whereTime)
            ->where('patient_status',$patientStatus)
            ->get();
    }


    /*
     * 患者诊断
     */
    protected function diagnose($whereTime,$appointment_status,$patient_type,$appointment_type)
    {
        return
            Patient::whereHas('appointments',function ($query)
            use($whereTime,$appointment_status,$patient_type,$appointment_type) {
                $query
                    ->where('patient_type',$patient_type)
                    ->where('appointments.type',$appointment_type)
                    ->where('appointments.status',$appointment_status)
                    ->where('appointments.appointment_date',$whereTime)
                    ->where('appointments.deleted_at',null);
            })->get();
    }


    /*
     * 获取主治医生
     */
    public function attendDoctor()
    {
        $user=Auth::user();
        if($user->is_admin==1){
            return message('',$this->getUserByRoleId([2,3,8],$user->clinic_id));
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
