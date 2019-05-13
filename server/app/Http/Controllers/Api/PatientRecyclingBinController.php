<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Patient;
use Illuminate\Support\Facades\DB;

class PatientRecyclingBinController extends Controller
{
    //
    protected $input = '';//参数
    public function __construct(Request $request){
    	$input = $request->input();
    	$pager = [];//分页参数
    	$unset_field = ['current_page','page_size','_d'];//删除字段
    	$unset_parms = function() use ($input,$unset_field,$pager){
    		foreach ($input as $k => $v) {
    			if (in_array($k,$unset_field)) {
    				$pager[$k] = $v;
    				unset($input[$k]);
    			}
    		}
    		return ['parms' => $input,'pager' => $pager];
    	};
    	$this->input = $unset_parms();
    }

    public function index(Request $request){
    	//获取患者回收站数据
    	$parms = array_filter($this->input['parms']);
    	$parms['status'] = 0;
    	$where = empty($parms)?'':' where';//去空

    	$length = count($parms)-1;//长度
    	$n = 0;//计数

    	$patient_group = config('config.patient_group');//类型转换

    	$case = '(case patients.group';//case
    	foreach ($patient_group as $k => $v) {
    		$case.=" when '$k' then '$v'";
    	}
    	$case.= " end )'group'";
    	$sql = "select id,name,sex,age,phone,content,source,$case from patients ".$where;
    	foreach ($parms as $k => $v) {
    		$sql.= " `$k` = :$k";
    		$n < $length?$sql.=' and':'';
    		$n++;
    	}

    	$sql.= ' limit '.($this->input['pager']['current_page']-1)*($this->input['pager']['page_size']).','.$this->input['pager']['page_size'];
    	$total = Patient::where('status',0)->count();
    	$res = getData($sql,$parms,1);//处理
    	$res['data']['total'] = $total;
    	return message($res['msg'],$res['data'],$res['code']);

    }

}
