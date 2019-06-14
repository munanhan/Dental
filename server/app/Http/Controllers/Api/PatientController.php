<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\AttendDoctor;
use App\Model\Appointment;
use App\Model\Patient;
use App\Model\PatientDisposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class PatientController extends BaseController
{
    const SERIAL_NUMBER="serial.number:";

    const DEFAULT_LENGTH=3;

    use AttendDoctor;

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

    public function update()
    {

        $patient=$this->parms;
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

        return message('',$this->parms, 200);
    }

    public function delete($id)
    {
        $type=request('type');
        dd($id,$type);
        Appointment::where('id',$id)->delete();

        $patient=Patient::find($id);
        $patient->delete();

        return message('',null, 200);
    }

    public function deleteWork()
    {
        $id=request('id');

        if(PatientDisposal::find($id)){
            return message('已有处置记录不可删除','',400);
        }else{
            $app=Appointment::find($id);
            $app->delete();
            return message('删除成功','',200);
        }
    }


    /*
     * 今日工作
     */
    public function todayWork()
    {
        $whereTime=request('whereTime');

        $data['appointmentNotArrive']=$this->appointmentNotArrive($whereTime);
        $data['todayFirstVisit']=$this->todayFirstVisit($whereTime);
        $data['todaySubsequentVisit']=$this->todaySubsequentVisit($whereTime);

        return message('',$data,200);
    }


    /*
     * 预约未到
     */
    public function appointmentNotArrive($whereTime)
    {
        return $this->diagnose($whereTime,'',[0,1,3]);
    }

    /*
     * 今日初诊
     */
    public function todayFirstVisit($whereTime)
    {
        return $this->diagnose($whereTime,0,[2]);
    }

    /*
     * 今日复诊
     */
    public function todaySubsequentVisit($whereTime)
    {
        return $this->diagnose($whereTime,1,[2]);
    }

    /*
     * 患者诊断
     */
    protected function diagnose($whereTime,$type,array $status)
    {
        return
        $this->patientAll()
            ->whereIn('apt.status',$status)
            ->whereDate('appointment_date',$whereTime)
            ->when($type,function ($query,$type){
                return $query->where('type',$type);
            })
            ->get();
    }


    /*
     * 全部患者
     */
    public function index()
    {

        $data['recentPatient']=$this->recentPatient();
        $data['blacklistPatient']=$this->blacklistPatient();
        $data['completePatient']=$this->completePatient();

        return message('',$data,200);

    }

    protected function searchPatient()
    {
        $flag=request('flag');
        $where=request('search');
        return
            $this->patientAll()
                ->whereNotIn('status',[5])
                ->where('patient_group','=',0)
                ->whereBetween('appointment_date',[now()->modify('-30 days')->toDateString(),now()->toDateString()])
            //->whereRaw('1=1')
                ->when(($flag==1),function ($query)use($where){
                    return $query->where('patient_name','like','%'.$where.'%')
                        ->orWhere('patient_phone','like','%'.$where.'%');
                })
                ->when(($flag==2),function ($query)use ($where){
                    return $query->where('case_id','like','%'.$where.'%');
                })
                ->when(($flag==3),function ($query)use ($where){
                    return $query->where('member_card'.'like','%'.$where.'%');
                })
                ->when(($flag==4),function ($query)use ($where){
                    return $query->whereBetween('created_at',[now()->modify('-3 days')]);
                })

                ->get();
    }


    /*
     * 最近患者
     */
    protected function recentPatient()
    {
        return
        $this->patientByGroup(0);
    }

    /*
     * 黑名单患者
     */
    protected function blacklistPatient()
    {
        return
        $this->patientByGroup(1);
    }

    /*
     * 治疗完成患者
     */
    protected function completePatient()
    {
        return
        $this->patientByGroup(2);
    }

    /*
     * 根据分组获取患者
     */
    protected function patientByGroup($group)
    {
        return
            $this->patientAll()
                ->whereDate('p.created_at','>=',now()->modify('-30 days'))
                ->where('patient_group','=',$group)
                ->get();
    }

    /*
     * 所有患者
     */
    protected function patientAll()
    {
        return
        DB::table('patients as p')
            ->leftJoin('appointments as apt','p.id','=','apt.patient_id')
            ->leftJoin('patient_orders as o','p.id','=','o.patient_id')
            ->selectRaw('p.id,patient_name,patient_age,patient_sex,patient_phone,member_id,member_card,allergy,anamnesis,patient_category,patient_group,SUM(o.arrearage) as arrearage,apt.status,start_time,over_time,apt.type,appointment_doctor,appointment_date,items')
            ->whereRaw('1=1')
            ->whereNull('p.deleted_at')
            ->groupBy('p.id');
    }


    /*
     * 获取主治医生
     */
    public function attendDoctor()
    {
        return $this->getDoctorByRoleId([1,2,3,8]);
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
