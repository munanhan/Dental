<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\AttendDoctor;
use App\Model\Role;
use Illuminate\Http\Request;
use App\Model\PatientConsult;
use Illuminate\Support\Facades\Auth;

class PatientConsultController extends BaseController
{

    use AttendDoctor;
    
    /*
     * 接着医生和资料录入人
     */
    public function getDoctorOrRecorder()
    {
        $user=Auth::user();
        if($user->is_admin==1){
            return $this->getDoctorByRoleId(Role::all('id')->toArray());
        }else{
            return $this->defaultRecorder();
        }

    }

    /*
     * 默认资料录入人
     */
    public function defaultRecorder()
    {
        $data=Auth::user()->name;
        return message('',$data,200);
    }
}
