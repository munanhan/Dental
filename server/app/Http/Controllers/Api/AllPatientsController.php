<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/19
 * Time: 17:21
 */

namespace App\Http\Controllers\Api;


class AllPatientsController extends PatientController
{
    /*
    * 全部患者
    */
    public function allPatient()
    {
        $keywords=request('keywords');
        $flag=request('flag');
        $data['recentPatient']=$this->patientByGroup(0,$flag,$keywords);
        $data['blacklistPatient']=$this->patientByGroup(1,$flag,$keywords);
        $data['completePatient']=$this->patientByGroup(2,$flag,$keywords);

        return message('',$data,200);

    }
}