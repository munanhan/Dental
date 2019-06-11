<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\OperationLog;
use Illuminate\Support\Facades\DB;
use App\Model\Privilege;
use App\Model\User;
use App\Http\Controllers\Api\BaseController;

class OperationLogController extends BaseController
{	

    public function operationLogList(Request $request){
    	//获取操作日志列表	
    	$parms = $request->input();
    	$source = getParms($parms);
    	//处理参数
    	try{
    		//当source返回false的时候表示获取全数据不需要处理。当source非false的时候则按条件筛选数据。
    		$data = OperationLog::where($source['parms'])
    							->whereBetween('created_at',[$source['date']['dtfm'],$source['date']['dtto']])
    							->get();
    		// dd( DB::getQueryLog());
	    	$message = '成功';
	    	$code = 200;
    	}catch(\Exception $e){
    		// dd($e->getMessage());
    		$message = '异常';
    		$code = 500;
    		$data = [];
    	}

    	return message($message,$data,$code);
    }

    public function getUserList(Request $request){
    	//获取下拉框用户列表
    	try{
    		$data = User::get(['name']);
	    	$message = '成功';
	    	$code = 200;
    	}catch(\Exception $e){
    		$message = '异常';
    		$code = 500;
    		$data = [];
    	}
    	return message($message,$data,$code);
    	
    }

    public function getModuleList(){
    	//获取模块下拉
    	try{
    		$data = Privilege::get(['module']);
	    	$message = '成功';
	    	$code = 200;
    	}catch(\Exception $e){
    		$message = '异常';
    		$code = 500;
    		$data = [];
    	}

    	return message($message,$data,$code);
    }
}
