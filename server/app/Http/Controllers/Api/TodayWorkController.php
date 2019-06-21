<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/19
 * Time: 17:19
 */

namespace App\Http\Controllers\Api;


use App\Model\Appointment;

class TodayWorkController extends PatientController
{
    /*
     * 根据id删除今日工作
     */
    public function deleteTodayWork()
    {
        $id=request('id');

        if(\App\Model\PatientDisposal::find($id)){
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
}