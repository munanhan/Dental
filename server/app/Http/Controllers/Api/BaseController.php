<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\BaseModel;
use Illuminate\Support\Facades\Auth;
use App\Model\OperationLog;

class BaseController extends Controller
{

        protected $model = '';
        //模型
        protected $table = '';
        //表
        protected $parms = [];
        //参数
        protected $pager = [];
        //分页
        protected $date = [];
        //日期
        protected $join = '';
        //连表
        protected $group = [];
        //分组
        protected $field = '';
        //字段
        protected $where = [];
        //条件
        protected $replace_field = [];
        //替换字段
        protected $having = '';
        //having条件

        public function __construct(Request $request){

            $action = explode('@',\Route::current()->getActionName());
            //获取路由
            $input = getParms($request->all());
            //拆分参数

            $this->parms = $input['parms'];
            $this->pager = $input['pager'];
            $this->date = $input['date'];

            if ($this->table == '') {
                if(preg_match("/\w+Controller/",$action[0],$preg)){
                    //匹配控制器
                    request()->attributes->set('config_load','verify_fields.'.$preg[0].'.'.$action[1]);//设置验证参数

                    $table = str_replace('Controller','s',$preg[0]);

                if (preg_match_all("/\S[A-Z]/",$table,$preg)) {
                    //按照laravel的匹配方式处理模型
                    foreach ($preg[0] as $k => $v) {
                       $table = str_replace($v,$v[0].'_'.$v[1],$table);
                    }
                }

                    $table = strtolower($table);

                }

                $this->table = $table;
            }
            request()->attributes->set('table',$this->table);//表
            
            $this->model = new BaseModel($this->table);
            //实例化

            $_log = [ 'addData' => '添加', 'delete' => '删除','update' => '修改' ];
            $module = config('config.module'.$this->table);
            //模块
            if ($module && array_key_exists($action[1], $_log) ) {
                //日志
                $log = [ 'operation_type' => $_log[$action[1]],
                         'operation_content' => Auth::user()['name'].$_log[$action[1]].'了一条'.$module.'数据',
                         'module' => $module
                       ];

                OperationLog::insert($log);
            }

        }

        public function index(){
            //主页,对应get方法，默认获取全部，可带参数

            if (empty($this->field)) {
                $this->field = ' * ';
            }

            $_select = [ 'table' => $this->table,'field' => $this->field ];

            //select语句
            $sql = MySelect($_select);

            if (!empty($this->join)) {
            //join 语句
                $sql.= MyJoin($this->join,'left');
            }

            if (!empty($this->parms)) {
            //where 语句
                $where = [];
                if (!empty($this->replace_field)) {
                    foreach ($this->parms as $k => $v) {
                        if (array_key_exists($k, $this->replace_field)) {
                            if (empty($this->replace_field[$k])) {
                                $having[] = $k;
                                continue;
                            }
                            $where[$this->replace_field[$k]] = $k;
                            continue;
                        }
                        $where[$k] = $k;
                    } 
                }
                else{

                    $where = $this->parms;
                }

                $sql.= MyWheres($where);
            }

            if (!empty($this->group)) {
            //group 语句
                $sql.= MyGroup($this->group);
            }

            if (!empty($this->having)) {
            //having 语句
                $having_where = [];
                $having = isset($having)?$having:[];
                foreach ($this->having as $k => $v) {
                    if(in_array($k, $having)){
                        $having_where[] = $v;
                    }
                }
                $sql.= !empty($having_where)?MyHaving($having_where):' ';
            }

            if (!empty($this->pager['current_page']) &&  !empty($this->pager['page_size'])) {
            //分页
                $sql.= MyLimit($this->pager);
                $total = $this->model->getCount();
                $res = getData($sql,$this->parms);
                return message($res['msg'],[ 'row' => $res['data'],'total' => $total ],$res['code']);
            }

            $res = getData($sql,$this->parms);

            return message($res['msg'],$res['data'],$res['code']);

        }

        public function getById(){
            //get by id
            $data = empty($this->join)?$this->model->getById(['id' => $this->parms['id']]):$this->getBySelect()['data'][0];
            return message('成功',$data,200);
        }

        public function addData(){
            //添加
            $res = $this->model->insertDataGetId($this->parms);

            if ($res) {
               
                return message('新增成功',$this->model->getById(['id' => $res]),200);
            }
            else{
                return message('新增失败',[],500);
            }
        }

        public function update(){
            //改
            $parms = $this->parms;
            $where['where'] = ['id' => $parms['id']];
            unset($parms['id']);
            $where['update'] = $parms;

            $res = $this->model->updateData($where);

            if ($res) {

                if (empty($this->join)) {

                    return message('修改成功',$this->model->getById(['id' => $this->parms['id']]),200);
                }

                return message('修改成功',$this->getBySelect()['data'][0],200);

            }
            else{
                return message('修改失败',[],500);
            }
        }

        public function delete($id){
            //删
            $res = $this->model->deleteData(['id' => $id]);
            if ($res) {

                return message('删除成功',null, 200);
            }
            else{
                return message('删除失败',null, 500);
            }
        }

        public function getBySelect(){
            //获取单条数据
            if (empty($this->field)) {
                $this->field = ' * ';
            }

            $_select = [ 'table' => $this->table,'field' => $this->field ];
            //select语句
            $sql = MySelect($_select);

            if (!empty($this->join)) {
            //join 语句
                $sql.= MyJoin($this->join,'left');
            }

            $sql.= MyWheres([$this->table.'.id' => 'id']);

            if (!empty($this->group)) {
            //group 语句
                $sql.= MyGroup($this->group);
            }

            return getData($sql,['id' => $this->parms['id']]);
        }
}
