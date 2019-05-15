<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Disposal;

class DisposalController extends Controller
{
    public function index(Request $request){
    	$parms = getParms($request->input())['parms'];
    	$_case_mode = [
	    		      	'data' => config('config.billing_mode'),//收费模式
	    		      	'table' => 'disposals',//表
	    		      	'field' => 'billing_mode'
	    			  ];
    	$_select = [
    				   'table' => 'disposals',//表
    				   'field' => 'disposals.id,disposal_code,disposal_name,price,unit,cost_categories.category,remarks,mem_discount,'.caseThen($_case_mode)
    			   ];
    	$_join = [
    				'cost_categories' => 'cost_categories.id = disposals.cate_id'
    			 ];
    	$_where = [
    				   'cate_id' => $parms['id']
    	          ];
    	          
    	$sql = MySelect($_select).MyJoin($_join).MyWhere($_where);
    	$res = getData($sql,$_where);
    	return message($res['msg'],$res['data'],$res['code']);

    }

    public function update(Request $request){
        $parms = getParms($request->input())['parms'];
        $fields = [//必填项
                     'billing_mode' => '收费模式',
                     'category' => '费用类型',
                     'disposal_code' => '处置代码',
                     'disposal_name' => '处置名称',
                     'mem_discount' => '会员折扣',
                     'price' => '价格',
                     'unit' => '单位'
                  ];
        $res = checkParms($fields,$parms);
        if ($res) {
            return message($res,[],404);
        }

        $res = Disposal::where('id',$parms['id'])->update($parms);

        if ($res) {
            return message('修改成功',$parms,200);
        }
        else{
            return message('修改失败',[],500);
        }
    }
}
