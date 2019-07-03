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

class ClinicOperationController extends BaseController
{
   
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
        sum(type=1) as next_visit ,sum(1) as total_visit from appointments 
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
        sum(type=1) as next_book,sum(1) as total_book  from appointments 
        where date(appointment_date) BETWEEN :dtfm and :dtto group by appointment_date;";

        $res = getData($sql,$this->date);
        return message('获取成功',$res,200);
    }
    
   

}
