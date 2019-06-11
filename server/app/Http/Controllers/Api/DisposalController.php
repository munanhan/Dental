<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Disposal;
use App\Http\Controllers\Api\BaseController;
use App\Exports\BaseExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class DisposalController extends BaseController
{
            public function index(){
                //主页
                $res = $this->getData();
            	return message($res['msg'],$res['data'],$res['code']);

            }

            public function getData($export = false){
                //获取数据
                $parms = $this->parms;
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

                $mem_discount = $export == false?'mem_discount':caseThen([ 'data' => [ 0 => '否',1 => '是'],
                                                           'table' => 'disposals',
                                                           'field' => 'mem_discount']);

                $_select = [
                               'table' => 'disposals',//表
                               'field' => 'disposals.id,disposals.id as disposal_id,disposal_code,disposal_name,price,unit,cost_categories.category,remarks,'.caseThen($_case_mode).','.caseThen($_medical_insurance).','.$mem_discount
                           ];

                $_join = [
                            'cost_categories' => 'cost_categories.id = disposals.cate_id'
                         ];


                $_where = [];
                isset($parms['id'])?$_where[] = ['cate_id','=',$parms['id']]:'';
                isset($parms['disposal_name'])?$_where[] = ['disposal_name','like',$parms['disposal_name']]:'';

                $sql = MySelect($_select).MyJoin($_join).MyWhere($_where);

                return getData($sql,dbParms($_where));
            }

            public function getById(){
                //get by id
                $id = $this->parms['id'] != ''?$this->parms['id']:0;
                if (!$id) {
                    return message('缺少id',[],404);
                }
                $data = Disposal::where('id',$id)->first();
                return message('成功',$data,200);
            }

            public function addData(){
                //添加
                $parms = $this->parms;
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
                $res = Disposal::create($parms);
                if ($res) {
                    return message('新增成功',$res,200);
                }
                else{
                    return message('新增失败',[],500);
                }
            }

            public function update(){
                //改
                $parms = $this->parms;
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
                $res = Disposal::destroy($id);
                if ($res) {
                    return message('删除成功',null, 200);
                }
                else{
                    return message('删除失败',null, 500);
                }
            }

            public function export(){
                //导出
                $data = $this->getData(true)['data'];
                //获取数据
                $export_data = [];
                array_push($export_data, [ '处置代码','处置名称','价格','单位','按会员折扣','费用类型','收费方式','备注' ]);

                foreach ($data as $k => $v) {
                    $temp[] = $v->disposal_code;
                    $temp[] = $v->disposal_name;
                    $temp[] = $v->price;
                    $temp[] = $v->unit;
                    $temp[] = $v->mem_discount;
                    $temp[] = $v->category;
                    $temp[] = $v->billing_mode;
                    $temp[] = $v->remarks;
                    array_push($export_data,$temp);
                    $temp = [];
                }
                return Excel::download(new BaseExport($export_data), '处置大类.xlsx');


            }
}
