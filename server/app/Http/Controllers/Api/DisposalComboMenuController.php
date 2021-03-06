<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Disposal;
use App\Model\DisposalComboMenu;
use App\Model\DisposalCombo;
use App\Http\Controllers\Api\BaseController;

class DisposalComboMenuController extends BaseController
{
            public function index(){
                //主页
                $data = DisposalComboMenu::all();
                return message('成功',getTree($data),200);
            }

            public function getById(){
                //get by id
                $id = $this->parms['id'] != ''?$this->parms['id']:0;
                if (!$id) {
                    return message('缺少id',[],404);
                }
                $data = DisposalComboMenu::where('id',$id)->first();
                return message('成功',$data,200);
            }

            public function addData(){
                //添加
                $parms = $this->parms;
                $fields = [//必填项
                             'combo_name' => '组合名'
                          ];

                $res = checkParms($fields,$parms);
                if ($res) {
                    return message($res,[],404);
                }

                $res = DisposalComboMenu::create($parms);
                if ($res) {
                    $this->insertLog();
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
                    $this->insertLog();
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
                $this->insertLog();
                return message('删除成功',null, 200);
            }
}
