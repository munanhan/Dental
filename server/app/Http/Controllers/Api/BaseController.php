<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\BaseModel;

class BaseController extends Controller
{

        protected $table = '';

        public function __construct(){

            $action = \Route::current()->getActionName();
            if(preg_match("/\w+Controller/",$action,$preg)){
                //匹配控制器
                $table = str_replace('Controller','s',$preg[0]);
            }
            if (preg_match_all("/\S[A-Z]/",$table,$preg)) {
                foreach ($preg[0] as $k => $v) {
                   $table = str_replace($v,$v[0].'_'.$v[1],$table);
                }
            }
            $this->table = strtolower($table);

        }

        public function index(Request $request){
            //主页
            $model = new BaseModel($this->table);
            $data = $model->getData();
            return message('成功',$data,200);
        }

        public function getById(Request $request){
            //get by id
            $id = $request->input('id') != ''?$request->input('id'):0;
            if (!$id) {
                return message('缺少id',[],404);
            }
            // $data = \App\Model\$model::where('id',$id)->first();
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

            // $res = \App\Model\$model::create($parms);
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

            // $res = \App\Model\$model::where('id',$parms['id'])->update($parms);

            if ($res) {
                // $data = \App\Model\$model::where('id',$parms['id'])->first();
                return message('修改成功',$data,200);
            }
            else{
                return message('修改失败',[],500);
            }
        }

        public function delete($id){
            //删
            // $res = \App\Model\$model::destroy($id);
            // $res2 = \App\Model\$model::where('p_id',$id)->delete();
            if ($res) {
                return message('删除成功',null, 200);
            }
            else{
                return message('删除失败',null, 500);
            }
        }
}
