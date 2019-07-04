<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Auth;

class DisposalComboController extends BaseController
{

        public function index(){
            //主页
            $parms = $this->parms;

            $_select = [
                            'table' => $this->table,
                            'field' => "combo_id,disposal_id,category,disposal_name,price,remarks,sum(combo_qty) as 'combo_qty',(price * sum(combo_qty)) as cost"
                       ];

            $_where = $parms;

            $_join = [
                           'disposals' => 'disposals.id = disposal_combos.disposal_id',
                           'disposal_combo_menus' => 'disposal_combo_menus.id = disposal_combos.combo_id',
                           'cost_categories' => 'cost_categories.id = disposals.cate_id'
                     ];

            $_gorup = ['disposal_id','combo_id'];

            $sql = MySelect($_select).MyJoin($_join,'left').MyWhere($_where).MyGroup($_gorup);
            $res = getData($sql,$parms);

            return message($res['msg'],$res['data'],$res['code']);

        }

        public function getById(){
            //获取
            $parms = $this->parms;

            $parms['combo_qty'] = $this->model->getCount($parms);
            if ($parms['combo_qty']) {
                return message('成功',$parms,200);
            }
            else{
                return message('失败',[],500);
            }
        }

        public function update(){
            //更新
            $parms['combo_id'] = $this->parms['combo_id'];
            $parms['disposal_id'] = $this->parms['disposal_id'];

            $res = $this->model->deleteData($parms);
            $res = true;
            //删除旧数据
            if ($res) {
                $insert = [];
                //新数据
                $combo_qty = $this->parms['combo_qty'];
                $parms['created_by'] = Auth::user()['name'];
                for ($i = 0;$i < $combo_qty;$i++) {
                    $insert[] = $parms;
                }
                $res = $this->model->insertData($insert);

                if ($res) {
                    $this->insertLog();
                    return message('成功',$this->parms,200);
                }
                else{
                    return message('失败',[],500);
                }

            }
            else{

                return message('失败',[],500);

            }
        }

        public function getList(){
            //获取列表
            $parms = $this->parms;
            $_select = [
                            'table' => 'disposal_combos',
                            'field' => 'disposal_id,disposal_combos.id,disposal_code,disposal_name,unit,price,category'
                       ];

            $_join = [
                        'disposals' => 'disposals.id = disposal_combos.disposal_id',
                        'cost_categories' => 'cost_categories.id = disposals.cate_id'
                     ];

            $_where['combo_id'] = $parms['id'];

            $sql = MySelect($_select).MyJoin($_join).MyWhere($_where);
            $res = getData($sql,$_where);

            return message($res['msg'],$res['data'],$res['code']);

        }

        public function addData(){
            //添加
            $combo_id = $this->parms['combo_id'];

            if(!isset($this->parms['list'])){
                return message('组合处置不能为空.',[],404);
            }

            $list = array_column($this->parms['list'],'disposal_id');

            $insert = [];
            foreach ($list as $k => $v) {
                $insert[$k]['combo_id'] = $combo_id;
                $insert[$k]['disposal_id'] = $v;
            }

            $this->model->deleteData(['combo_id' => $combo_id]);

            if($this->model->insertData($insert)){
                $this->insertLog();
                return message('成功',[],200);
            }
            else{
                return message('失败',[],500);
            }

        }

        public function delete($id){
            //删
            $res = $this->model->deleteData(['disposal_id' => $id]);
            if ($res) {
                $this->insertLog();
                return message('删除成功',null, 200);
            }
            else{
                return message('删除失败',null, 500);
            }
        }
}
