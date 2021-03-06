<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\AttendDoctor;
use App\Http\Controllers\Traits\CaseNumber;
use App\Model\Patient;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AppointmentController extends BaseController
{
    const SERIAL_NUMBER="serial.number:";

    const DEFAULT_LENGTH=3;

    use CaseNumber,AttendDoctor;

    public function getCaseNumber(){
       
       return $this->CaseNumber();
    }

    public function getDoctor()
    {
        return $this->getDoctorByRoleId([1,2,3,8]);
    }

    public function getPatientByPhone(Request $request){
        $data=$request->all();

        $data = Patient::where('patient_phone',$data['patient_phone'])->first(['patient_name','patient_age','patient_sex','patient_source']);

        return  message('修改成功',$data,200);

    }
    //修改预约状态
    public function changeAppointmentStatus(Request $request){
        $data=$request->all();
        $id = $data['id'];
        unset($data['id']);
        if($data['status'] == 4){
            $this->deletelw($id);
        }else{
            Appointment::where('id',$id)->update($data);
        }

        return  message('修改成功',$data,200);
    }
    //添加预约和修改预约
    public function addAppointment(Request $request){
        $oriData=$request->all();
        $patientArray = ['patient_name'=>'','patient_age'=>'','patient_sex'=>'','patient_phone'=>'','case_id'=>'','patient_content'=>'','patient_source'=>''];
        $data  =array_diff_key($oriData,$patientArray);
        $patientData= array_intersect_key($oriData,$patientArray);
//          数据库患者表删除了attend_doctor
//        $patientData['attend_doctor'] = $oriData['appointment_doctor'];
      

        //判断患者之前是否存在
        $patient = Patient::where('patient_phone',$patientData['patient_phone'])->first();
        if(empty($patient)){
             $patientData['patient_type'] = '1';
             $patient=Patient::create($patientData);
        }

        // $data['id'] 存在即修改
        if(isset($oriData['id'])){
            $id = $oriData['id'];

            $patient_id = $oriData['patient_id'];
            Appointment::where('id',$id)->update($data);
            Patient::where('id',$patient_id)->update($patientData);
            return  message('修改预约成功','',200);
        }




        $data['patient_id'] = $patient->id;
        $data['over_time'] = str_replace(substr($data['start_time'],0,2),
            (substr($data['start_time'],0,2)+1),$data['start_time']);

        //判断预约时间是否过期
       $selectTime = array_merge(explode("-", $data['appointment_date']),explode(" : ", $data['over_time']));
       $selectTime = Carbon :: create($selectTime[0],$selectTime[1],$selectTime[2],$selectTime[3],$selectTime[4],0);
       $DTime = Carbon :: now();
       if($DTime->gte($selectTime)){
           $data['status'] =3;
       }

       Appointment::create($data);

       return message('新增预约成功',[$DTime,$selectTime,$DTime->gte($selectTime)],200);
    }
    //获得今天或某天的数据
    public function getTodayAppointment(Request $request){

        $where =  \request('date')?request('date'):date('Y-m-d');
        $data=$request->all();
       $appoinment =new Appointment();
       $rightRes = [];
       $leftRes = [];
       if(isset($data['left_doctor'])){
        $leftRes =$appoinment->where('appointment_date',$where)->where('flag',1)->where('appointment_doctor',$data['left_doctor'])->leftJoin('patients','appointments.patient_id','=','patients.id')->
        get(['appointments.*','patients.patient_name','patients.patient_age','patients.case_id','patients.patient_sex','patients.patient_phone','patients.patient_content','patients.patient_source']);
       }
      
       if(isset($data['right_doctor'])){
        $rightRes =$appoinment->where('appointment_date',$where)->where('flag',1)->where('appointment_doctor',$data['right_doctor'])->leftJoin('patients','appointments.patient_id','=','patients.id')->
        get(['appointments.*','patients.patient_name','patients.patient_age','patients.case_id','patients.patient_sex','patients.patient_phone','patients.patient_content','patients.patient_source']);
       }
       
        return message('获取成功',[$leftRes,$rightRes],200);

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
        $res =$appoinment->where('flag',1)->where('appointment_date','>=',$weekStart)->where('appointment_date','<=',$weekEnd)->leftJoin('patients','appointments.patient_id','=','patients.id')->
        get(['appointments.*','patients.patient_name','patients.patient_age','patients.case_id','patients.patient_sex','patients.patient_phone','patients.patient_content','patients.patient_source']);

        return message('获取成功',$res,200);
    }
    public function getListAppointment(Request $request){
        $data=$request->all();
        $parms['dtfm'] = isset($data['dtfm'])?$data['dtfm']:0;
        $parms['dtto'] = isset($data['dtto'])?$data['dtto'].' 23:59:59':date('Y-m-d').' 23:59:59';//日期
       
        $sql = "select b.*,a.patient_name,a.patient_age,a.case_id,a.patient_sex,a.patient_phone,a.patient_content,a.patient_source";
        $countSql  = "select count(1) as total";
        $commonsql = " from patients a LEFT JOIN appointments b on a.id = b.patient_id where date(appointment_date) BETWEEN :dtfm and :dtto and b.flag = 1";
        if($data['statusRadio'] != '全部'){
            $commonsql .= " and b.status = ".$data['statusRadio'];
        }
        $sql .=$commonsql;
        $countSql .= $commonsql;
     
        $total = getData($countSql,$parms);
 
        
        $sql .= " limit :current , :size";
        $parms['current'] = ($data['current']-1) * $data['size'];
        $parms['size'] = +$data['size'];
        $res = getData($sql,$parms);



        return [$res,$total];
    }
    //获取某个月的数据
    public function getMonthAppointment(Request $request){
        $data=$request->all();
        $startMonth = $data['start'];
        $endMonth = $data['end'];
        $appoinment =new Appointment();

        $now = explode(" ", date("Y-m-d H:i"));
        $now[1] = str_replace(':',' : ',$now[1]);
        Appointment::where('status','0')->where('appointment_date','<',$now[0])->update(['status'=>3]);
        Appointment::where('status','0')->where('appointment_date','=',$now[0])->where('over_time','<=',$now[1])
        ->update(['status'=>3]);
        $res =$appoinment->where('flag',1)->where('appointment_date','>=',$startMonth)
        ->where('appointment_date','<=',$endMonth)->leftJoin('patients','appointments.patient_id','=','patients.id')->
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
    //获得患者来源统计
    public function clinicPatientSource(Request $request){


        $sql = "select a.patient_source as type,count(1) as num from patients a 
        LEFT JOIN appointments b 
        on a.id = b.patient_id
        where date(appointment_date) BETWEEN :dtfm and :dtto
        group by a.patient_source";

        $res = getData($sql,$this->date);
        return message('获取成功',$res,200);
    }
    //获得就诊人数统计
    public function clinicVisitData(Request $request){
        // dd($request->all());

        // $data=$request->all();
        // $parmas['start'] = $data['dateRange'][0];
        // $parmas['end'] = $data['dateRange'][1];

        $sql = "select appointment_date as date,sum(type=0) as first_visit,
        sum(type=1) as next_visit,sum(1) as total_visit	from appointments 
        where date(appointment_date) BETWEEN :dtfm and :dtto and status='2' group by appointment_date;";

        $res = getData($sql,$this->date);
        return message('获取成功',$res,200);
    }
    //获得预约人数统计
    public function clinicAppointData(Request $request){
        // dd($request->all());

        // $data=$request->all();
        // $parmas['start'] = $data['dateRange'][0];
        // $parmas['end'] = $data['dateRange'][1];

        $sql = "select appointment_date as date,sum(type=0) as first_book,
        sum(type=1) as next_book,sum(1) as total_book from appointments 
        where date(appointment_date) BETWEEN :dtfm and :dtto group by appointment_date;";

        $res = getData($sql,$this->date);
        return message('获取成功',$res,200);
    }
    
    /*
     * 软删除
     */
    public function deletelw($id)
    {

        $app=Appointment::find($id);
        $app->delete();
    }

    /*
     * 恢复软删除
     */
    public function restore()
    {
        $id=request('id');
        $app=Appointment::withTrashed()->find($id);
        $app->restore();
    }

    /*
     * 强制删除
     */
    public function force()
    {
        $id=request('id');
        $app=Appointment::find($id);
        $app->forceDelete();
    }

}
