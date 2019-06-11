<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Patient;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\BaseController;

class PatientRecyclingBinController extends BaseController
{

    public function index(){
    	//获取患者回收站数据
    	$parms = $this->parms;
    	$pager = $this->pager;

    	//顺序，获取case->select->case->join(后面补充)->where->limit;
    	$patient_group = config('config.patient_group');//类型转换,设置case
    	$caseGroup = ['data' => $patient_group,'table' => 'patients','field' => 'patient_group'];
    	$case = caseThen($caseGroup);//case

    	$select = [ 
    				'field' => ['id','patient_name','patient_sex','patient_age','patient_phone','patient_content','patient_source',$case],
    				'table' => 'patients',
    			  ];//设置字段

    	$limit = [  
    				'current_page' => $pager['current_page'],//设置分页
    				'page_size' => $pager['page_size']
    			 ];

        $where[] = [ 'deleted_at','<>','' ];

        foreach ($parms as $k => $v) {
            $where[] = [ $k,'=',$v ];
        }

        $parms['deleted_at'] = '';

    	$sql = MySelect($select).MyWhere($where).MyLimit($limit);

    	$total = Patient::where('deleted_at','<>','')->count();

    	$res = getData($sql,$parms,1);//处理
    	$res['data']['total'] = $total;
    	return message($res['msg'],$res['data'],$res['code']);

    }

    public function update(){
    	//还原被删除的患者
    	$id = empty($this->parms['id'])?0:$this->parms['id'];
    	if ($id == 0) {
    		return message('缺少id',[],404);
    	}

    	$res = Patient::where('id',$id)->restore();

    	if ($res) {
    		return message('成功',[],200);
    	}
    	else{
    		return message('失败',[],500);
    	}

    }

    public function delete($id){
    	$id = empty($id)?0:$id;
    	if ($id == 0) {
    		return message('缺少id',[],404);
    	}
    	$res = Patient::where('id',$id)->forceDelete();
    	if ($res) {
    		return message('成功',[],200);
    	}
    	else{
    		return message('失败',[],500);
    	}
    }

    public function deleteAll(Request $request){
    	//批量删除
    	$id = empty($request->input('id'))?0:$request->input('id');
    	if ($id == 0) {
    		return message('缺少id',[],404);
    	}
    	$res = Patient::whereIn('id', $id)->forceDelete();
    	if ($res) {
    		return message('成功',[],200);
    	}
    	else{
    		return message('失败',[],500);
    	}
    }

    

}
