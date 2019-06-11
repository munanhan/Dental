<?php
namespace App\Http\Controllers\Traits;
use Illuminate\Support\Facades\Auth;

Trait AttendDoctor
{
    public function getDoctorByRoleId(array $roleId)
    {
        $user=Auth::user();
        if($user->is_admin==1){
            return message('',$this->getUserByRoleId($roleId,$user->clinic_id));
        }else{
            return message(Auth::user());
        }
    }

    /*
  * 根据角色和诊所获取医生
  */
    public function getUserByRoleId(Array $roles,$clinicId)
    {
        return Auth::user()->whereHas('roles',function ($query)use($roles,$clinicId){
            $query->whereIn('roles.id',$roles)->where('clinic_id',$clinicId);
        })->get();
    }
}