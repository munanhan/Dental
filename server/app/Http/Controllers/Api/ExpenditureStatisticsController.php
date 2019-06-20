<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ExpenditureController;
use Illuminate\Support\Facades\DB;

       
class ExpenditureStatisticsController extends ExpenditureController
{

	public function getSelect(){
		//获取下拉
		$data = DB::table('users')->get(['id','name']);

		return message('成功',$data,200);
	}

}
