<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Disposal;
use App\Model\DisposalComboMenu;
use App\Model\DisposalCombo;

class DisposalComboMenuController extends Controller
{
            public function index(Request $request){
                //主页
                $data = DisposalComboMenu::all();
                return message('成功',getTree($data),200);
            }

            public function getById(Request $request){
                //get by id
                $id = $request->input('id') != ''?$request->input('id'):0;
                if (!$id) {
                    return message('缺少id',[],404);
                }
                $data = DisposalComboMenu::where('id',$id)->first();
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

                $res = DisposalComboMenu::create($parms);
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
                             'id' => 'id值',
                             'combo_name' => '组合名字'
                          ];
                $res = checkParms($fields,$parms);
                if ($res) {
                    return message($res,[],404);
                }

                $res = DisposalComboMenu::where('id',$parms['id'])->update($parms);

                if ($res) {
                    $data = DisposalComboMenu::where('id',$parms['id'])->first();
                    return message('修改成功',$data,200);
                }
                else{
                    return message('修改失败',[],500);
                }
            }

            public function delete($id){
                //删
                $ids = DisposalComboMenu::where('p_id',$id)->get(['id'])->toArray();
                $ids = array_column($ids,'id');
                array_push($ids,$id);
                DisposalComboMenu::destroy($ids);
                // DisposalComboMenu::where('p_id',$id)->delete();
                DisposalCombo::whereIn('combo_id',$ids)->delete();

                return message('删除成功',null, 200);
            }
}
