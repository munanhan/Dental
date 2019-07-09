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
    public function clinicPatientSource(Request $request)
    {


        $sql = "select a.patient_source as type,count(1) as num from patients a 
        LEFT JOIN appointments b 
        on a.id = b.patient_id
        where date(appointment_date) BETWEEN :dtfm and :dtto
        group by a.patient_source";

        $res = getData($sql, $this->date);
        return message('获取成功', $res, 200);
    }
    //获得就诊人数统计
    public function clinicVisitData(Request $request)
    {
        // dd($request->all());

        // $data=$request->all();
        // $parmas['start'] = $data['dateRange'][0];
        // $parmas['end'] = $data['dateRange'][1];


        $sql = "select appointment_date as date,sum(type=0) as first_visit,
        sum(type=1) as next_visit ,sum(1) as total_visit from appointments 
        where date(appointment_date) BETWEEN :dtfm and :dtto and status='2' group by appointment_date;";

        $res = getData($sql, $this->date);
        return message('获取成功', $res, 200);
    }
    //获得预约人数统计
    public function clinicAppointData(Request $request)
    {
        // dd($request->all());

        // $data=$request->all();
        // $parmas['start'] = $data['dateRange'][0];
        // $parmas['end'] = $data['dateRange'][1];

        $sql = "select appointment_date as date,sum(type=0) as first_book,
        sum(type=1) as next_book,sum(1) as total_book  from appointments 
        where date(appointment_date) BETWEEN :dtfm and :dtto group by appointment_date;";


        $res = getData($sql, $this->date);
        return message('获取成功', $res, 200);
    }
    //获得预约人数统计
    public function clinicAppointItemData(Request $request)
    {
        // dd($request->all());

        // $data=$request->all();
        // $parmas['start'] = $data['dateRange'][0];
        // $parmas['end'] = $data['dateRange'][1];

        $sql = "select sum(items='拔牙') as tooth_extraction,sum(items='试戴义齿') as denture,sum(items='换药') as dressing_change,sum(items='补牙') as tooth_filling,sum('戴牙') as wearing_teeth,
        sum('手术') as surgery,sum('拆线') as remove_stitches,sum('根管设备') as root_canal_equipment,sum('试内冠') as trial_crown
        ,sum('根管治疗') as root_canal_therapy from appointments 
       where date(appointment_date) BETWEEN :dtfm and :dtto;";
        $res = getData($sql, $this->date);
        return message('获取成功', $res, 200);
    }
    //获得预约状态统计
    public function clinicAppointStatusData(Request $request)
    {
        // dd($request->all());

        // $data=$request->all();
        // $parmas['start'] = $data['dateRange'][0];
        // $parmas['end'] = $data['dateRange'][1];
        $sql = "select status as type,count(1) as status from appointments 
        where date(appointment_date) BETWEEN :dtfm and :dtto
        group by status";
        $res = getData($sql, $this->date);
        return message('获取成功', $res, 200);
    }
}
