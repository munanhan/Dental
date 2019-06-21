<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/19
 * Time: 17:22
 */

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RecentVisitController extends PatientController
{

    /*
     * 最近访问患者
     */
    public function recentVisitPatient()
    {
        $idArray=$this->getRecentVisitPatientId();

        $idString=implode(',',$idArray);

        $data=$this->patientAll()->whereIn('p.id',$idArray)
            ->orderByRaw(DB::raw("FIELD(p.id,$idString)"))->get();

        return message('',$data,200);
    }

    /*
     * 获取最近浏览患者的id
     */
    protected function getRecentVisitPatientId()
    {
        $subQuery=DB::table('recent_visits')
            ->where('user_id',Auth::id())
            ->whereDate('created_at','>=',now()->modify('-30 days'))
            ->latest()
            ->limit(99999);

        $query = DB::table(DB::raw("({$subQuery->toSql()}) as sub"))
            ->select('sub.patient_id')
            ->groupBy('sub.patient_id')
            ->orderBy('sub.created_at','DESC');

        $query->mergeBindings($subQuery);
        $result=json_decode($query->get(), true);

        $patientId=[];
        foreach ($result as ['patient_id'=>$id]){
            $patientId[]=$id;
        }

        return $patientId;
    }
}