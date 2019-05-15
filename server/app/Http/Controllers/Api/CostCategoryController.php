<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CostCategory;

class CostCategoryController extends Controller
{
    public function index(){
    	//左菜单
    	$data = CostCategory::get(['id','category']);
    	return message('成功',$data,200);
    }

    public function addCategory(Request $request){
    	//新增
    	$parms = getParms($request->input())['parms'];

    	$res = checkParms(['category' => '类别'],$parms);
    	if ($res) {
    		return message($res,[],404);
    	}
    	if(CostCategory::where($parms)->first()){
    		return message('该类别已存在',[],405);
    	}
    	$res = CostCategory::create($parms);
    	if ($res) {
    		return message('成功',$res,200);
    	}
    	else{
    		return message('失败',[],500);
    	}
    }

    public function delete($id){
    	//删
    	$res = CostCategory::destroy($id);
    	if ($res) {
    		return message('成功',[],200);
    	}
    	else{
    		return message('失败',[],500);
    	}
    }

    public function update(Request $request){
    	//改
    	$parms = getParms($request->all())['parms'];
    	$res = CostCategory::where('id',$parms['id'])->update($parms);
    	if ($res) {
    		return message('成功',$parms,200);
    	}
    	else{
    		return message('失败',[],500);
    	}
    }
}
