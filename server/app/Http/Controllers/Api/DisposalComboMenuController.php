<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Disposal;
use App\Model\DisposalCombo;

class DisposalComboMenuController extends Controller
{
            public function index(Request $request){
                //主页
            	$parms = getParms($request->input())['parms'];
            	$_case_mode = [
        	    		      	'data' => config('config.billing_mode'),//收费模式
        	    		      	'table' => 'disposals',//表
        	    		      	'field' => 'billing_mode'
        	    			  ];

                $_medical_insurance = [
                                        'data' => config('config.common_status'),//收费模式
                                        'table' => 'disposals',//表
                                        'field' => 'medical_insurance'
                                      ];
                
            	$_select = [
            				   'table' => 'disposals',//表
            				   'field' => 'disposals.id,disposal_code,disposal_name,price,unit,cost_categories.category,remarks,mem_discount,'.caseThen($_case_mode).','.caseThen($_medical_insurance)
            			   ];

            	$_join = [
            				'cost_categories' => 'cost_categories.id = disposals.cate_id'
            			 ];


                $_where = [];
                isset($parms['id'])?$_where[] = ['cate_id','=',$parms['id']]:'';
                isset($parms['disposal_name'])?$_where[] = ['disposal_name','like',$parms['disposal_name']]:'';

            	$sql = MySelect($_select).MyJoin($_join).MyWhere($_where);

            	$res = getData($sql,dbParms($_where));

            	return message($res['msg'],$res['data'],$res['code']);

            }

            public function getById(Request $request){
                //get by id
                $id = $request->input('id') != ''?$request->input('id'):0;
                if (!$id) {
                    return message('缺少id',[],404);
                }
                $data = Disposal::where('id',$id)->first();
                return message('成功',$data,200);
            }

            public function addCombo(Request $request){
                //添加
                $parms = getParms($request->input())['parms'];
                $fields = [//必填项
                             'combo_name' => '组合名'
                          ];

                $res = checkParms($fields,$parms);
                if ($res) {
                    return message($res,[],404);
                }

                $res = DisposalCombo::create($parms);
                if ($res) {
                    return message('新增成功',$res,200);
                }
                else{
                    return message('新增失败',[],500);
                }
            }

            public function update(Request $request){
                //改
                $parms = getParms($request->input())['parms'];
                $fields = [//必填项
                             'billing_mode' => '收费模式',
                             'cate_id' => '费用类型',
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

            public function delete($id){
                //删
                $res = DisposalCombo::destroy($id);
                if ($res) {
                    return message('删除成功',null, 200);
                }
                else{
                    return message('删除失败',null, 500);
                }
            }
}
