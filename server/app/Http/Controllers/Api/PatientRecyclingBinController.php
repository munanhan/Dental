<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Patient;
use Illuminate\Support\Facades\DB;

class PatientRecyclingBinController extends Controller
{
    //
    public function get(Request $request){
    	//获取患者回收站数据
    	$where['name'] = $request->input('name');
    	$where['phone'] = $request->input('phone');
    	$where['status'] = 0;
    	$length = count($where)-1;
    	$sql = 'select a.name,sex,age,phone,content from patients a left join patient_sources b on a.source_id = b.id where';
    	foreach ($where as $k => $v) {
    		$sql.= " $k = :$k";
    		$k < $length?$sql.=' and':'';
    	}

    }
}
