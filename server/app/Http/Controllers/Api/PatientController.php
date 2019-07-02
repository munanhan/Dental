<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\AttendDoctor;
use App\Http\Controllers\Traits\CaseNumber;
use App\Model\Appointment;
use App\Model\Patient;
use App\Model\PatientDisposal;
use App\Model\RecentVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class PatientController extends BaseController
{
    const SERIAL_NUMBER="serial.number:";

    const DEFAULT_LENGTH=3;

    use AttendDoctor,CaseNumber;

    /*
     * 根据id展示患者
     */
    public function show()
    {
            $data= Patient::where('id',request('id'))->get();
            return message('',$data,200);
    }

    /*
     * 添加患者
     */
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
                'attend_doctor'=>$appointment['appointment_doctor']])->first()){
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

    /*
     * 根据id更新患者信息
     */
    public function update()
    {
        $patient=$this->parms;

        $id=$patient['id'];

        Patient::where('id',$id)->update($patient);

        return message('',$this->parms, 200);
    }

    /*
     * 根据id删除患者
     */
    public function delete($id)
    {
        Appointment::where('id',$id)->delete();

        $patient=Patient::find($id);

        $patient->delete();

        return message('',null, 200);
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


    public function searchByName()
    {
        $keywords=request('keywords');
        $data=$this->patientByGroup(2,1,$keywords);
        return message('',$data,200);
    }

    /*
     * 根据分组获取患者
     */
    protected function patientByGroup($group,$flag,$where)
    {
          return
              $this->patientAll()
                  ->whereDate('p.created_at','>=',now()->modify('-30 days'))
                  ->when($group,function ($query) use ($group){
                      return $query->where('patient_group','=',$group);
                  })
                  ->when(($flag==1),function ($query)use($where){
                      return $query->whereRaw("LOCATE('$where', `patient_phone`)>0")
                          ->orWhereRaw("LOCATE('$where', `patient_name`)>0");
                  })
                  ->when(($flag==2),function ($query)use ($where){
                      return $query->where('case_id','like',$where.'%');
                  })
                  ->when(($flag==3),function ($query)use ($where){
                      return $query->where('member_card'.'like',$where.'%');
                  })
                  ->when(($flag==4),function ($query)use ($where){
                      return $query->where('appointment_doctor'.$where);
                  })
                  ->when(($flag==5),function ($query)use ($where){
                      return $query->whereDate('p.created_at','>=',[now()->modify('-3 days')]);
                  })
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
            ->selectRaw('p.id,case_id,patient_name,patient_age,patient_sex,patient_phone,member_id,member_card,allergy,anamnesis,patient_category,patient_group,SUM(o.arrearage) as arrearage,apt.status,start_time,over_time,apt.type,appointment_doctor,appointment_date,items')
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


    /*
     * 获取病历号
     */
    public  function getCaseNumber()
    {   
        return $this->CaseNumber();
    }

    


}
