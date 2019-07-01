<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/21
 * Time: 16:39
 */

namespace App\Http\Controllers\Api;


//预约
use App\Model\Appointment;

class PatientAppointController extends BaseController
{
    public function show()
    {
        $id=request('id');

        $data=Appointment::with('patient')
            ->where('patient_id',$id)
            ->where('flag','=',1)
            ->get();

        return message('',$data,200);
    }
}