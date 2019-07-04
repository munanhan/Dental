<?php
/**
 * Created by PhpStorm.
 * User: han
 * Date: 2019/6/18
 * Time: 11:00
 */

namespace App\Http\Controllers\Traits;


use App\Model\Patient;

Trait PatientBaseInfo
{
    public function getPatientBaseInfo($id)
    {
        return
        Patient::select('id','patient_name','patient_sex','patient_phone','case_id','patient_age')->where('id',$id)->first();
    }
}