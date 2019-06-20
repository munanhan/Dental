<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\BaseModel;
use Illuminate\Support\Facades\Auth;
use App\Model\OperationLog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\Exports\BaseExport;
use App\Imports\BaseImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

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
        protected $order = [];
        //排序
        protected $field = '';
        //字段
        protected $where = [];
        //条件
        protected $replace_field = [];
        //替换字段
        protected $having = '';
        //having条件
        protected $controller = '';
        //控制器
        protected $action = '';
        //方法
        protected $fail = false;
        //执行是否的方法
        protected $upload = [];
        //用于判断是否有上传文件
        protected $search_date = [];
        //搜索日期字段
        protected $export = [];
        //导出表头

        public function __construct(Request $request){

            $action = explode('@',\Route::current()->getActionName());
            //获取路由
            $input = getParms($request->all());
            //拆分参数
            $this->parms = $input['parms'];
            $this->pager = $input['pager'];
            $this->date = $input['date'];

            if(preg_match("/\w+Controller/",$action[0],$preg)){
                //匹配控制器
                request()->attributes->set('config_load','verify_fields.'.$preg[0].'.'.$action[1]);//设置验证参数
                
                $this->controller = $preg[0];

                $table = str_replace('Controller','s',$preg[0]);

                if (preg_match_all("/\S[A-Z]/",$table,$preg)) {
                    //按照laravel的匹配方式处理模型
                    foreach ($preg[0] as $k => $v) {
                       $table = str_replace($v,$v[0].'_'.$v[1],$table);
                    }
                }

                $table = strtolower(preg_replace("/ys$/",'ies',$table));
                //y变成ies

                $this->table = $this->table == ''?$table:$this->table;
                $this->action = $action[1];

            }
            request()->attributes->set('table',$this->table);//表
            request()->attributes->set('controller',$this->controller);//表
            request()->attributes->set('action',$this->action);//方法

            $this->model = new BaseModel($this->table);
            //实例化
            DB::connection()->enableQueryLog();
            //数据库日志查询

        }

        // public function __destruct(){
        //     //销毁事件,自动写入日志
        //     if (!$this->fail) {
        //         //判断写入是否失败，成功则插入日志
        //         //日志写入部分
        //         //要是用这个功能需要去config文件里面添加对应的模块以及名称，模块key为对应的表名，value为模块名称
        //         $_log = [ 'addData' => '添加', 'delete' => '删除','update' => '修改' ];
        //         $module = config('config.module.'.$this->table);
        //         //模块

        //         if ($module && array_key_exists($this->action, $_log) ) {
        //             //日志
        //             $log = [ 'operation_type' => $_log[$this->action],
        //                      'operation_content' => Auth::user()['name'].$_log[$this->action].'了一条'.$module.'数据',
        //                      'module' => $module,
        //                      'created_by' => Auth::user()['name'],
        //                      'created_at' => date('Y-m-d H:i:s')
        //                    ];

        //             OperationLog::insert($log);
        //         }
        //     }
        // }
        public function insertLog($parms = []){
            //写入日志
            //日志写入部分
            //要是用这个功能需要去config文件里面添加对应的模块以及名称，模块key为对应的表名，value为模块名称
            $_log = [ 'addData' => '添加', 'delete' => '删除','update' => '修改' ];

            $module = config('config.module.'.$this->table);
            //模块


            if ($module && array_key_exists($this->action, $_log) || !empty($parms)) {
                //日志
                $log = [ 'operation_type' => isset($parms['operation_type'])?
                                             $parms['operation_type']:
                                             $_log[$this->action],

                         'operation_content' => isset($parms['operation_content'])?
                                                $parms['operation_content']:
                                                Auth::user()['name'].$_log[$this->action].'了一条'.$module.'数据',
                         'module' => isset($parms['module'])?$parms['module']:$module,

                         'created_by' => Auth::user()['name'],
                         'created_at' => date('Y-m-d H:i:s')
                       ];

                $ok = '';
                //是否允许写入日志
                foreach ($log as $k => $v) {
                    $ok = empty($v)?false:true;
                }
                $ok == true?OperationLog::insert($log):'';
            }

        }

        public function index(){
            //主页,对应get方法，默认获取全部，可带参数
            $res = $this->getData();
            // dd($this->getLastSql());
            return message($res['msg'],$res['data'],$res['code']);

        }

        public function getData(){
            //获取数据
            $this->setWhereIn();
            //处理wherein参数

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

            $where = [];
            if (!empty($this->parms) && empty($this->where)) {
            //where 语句
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

            }

            if (!empty($this->search_date)) {
                foreach ($this->search_date as $k => $v) {
                    isset($this->date['dtfm'])?$where[] = [ $v,'>=', 'dtfm']:'';
                    isset($this->date['dtto'])?$where[] = [ $v,'<=', 'dtto']:'';
                }
                $this->parms['dtfm'] = isset($this->date['dtfm'])?$this->date['dtfm']:0;
                $this->parms['dtto'] = isset($this->date['dtto'])?$this->date['dtto']:0;
            }

            $sql.= MyWheres( array_merge($where,$this->where));

            // else if (!empty($this->search_date)) {
            //     // foreach ($this->search_date as $k => $v) {
            //     //     $where[$v] = isset($this->date['dtfm'])?$this->date['dtfm']:0;
            //     // }
            // }

            // dd($where);

            if (!empty($this->group)) {
            //group 语句
                $sql.= MyGroup($this->group);
            }

            if (!empty($this->order)) {
                $sql.= MyOrder($this->order);
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
                $count_sql = preg_replace("/^select.*from/",'select count(*) as total from',$sql);

                $sql.= MyLimit($this->pager);
                // $total = $this->model->getCount($where);
                $total = getData($count_sql,$this->parms);
                $res = getData($sql,$this->parms);
                return [ 'msg' => $res['msg'], 'data' => [ 'row' => $res['data'],'total' => $total['data'][0]->total ], 'code' => $res['code']];
            }
            
            return getData($sql,$this->parms);
        }

        private function setWhereIn(){
            //遇到数组参数的时候去处理where in条件
            //把数组元素拆开，然后赋值到where in条件上
            if (empty($this->parms)) {
                return false;
            }
            foreach ($this->parms as $k => $v) {
                if(is_array($this->parms[$k])){
                    //判断，如果是个数组则处理
                    $in_where = [];
                    //
                    foreach ($this->parms[$k] as $parms_key => $parms_val) {
                        //把数组拆分，然后以数组原本数组名+key顺序的方式注入新的参数
                        $this->parms[$k.($parms_key+1)] = $parms_val;
                        $in_where[] = ':'.$k.($parms_key+1);//在in条件参数列表中添加该key对应的值
                    }
                    unset($this->parms[$k]);//最后删除原本的数组参数，以免报错
                    $this->where = [ [ $k,'in',implode(',', $in_where) ] ];//设置where条件
                }
            }
            return true;

        }

        public function getById(){
            //get by id
            // $data = empty($this->join)?$this->model->getById(['id' => $this->parms['id']]):$this->getBySelect()['data'][0];
            if (isset($this->parms['id'])) {
                //默认取的id
                $where['id'] = $this->parms['id'];
            }
            else{
                //否则取注入的条件作为查询条件
                $where = $this->parms;
            }
            $data = $this->model->getById($where);
            if ($data) {
                return message('获取成功',$data,200);
            }
            // return message('获取失败',[],500);
            return message('获取成功',new \stdClass(),200);
        }

        public function addData(){
            //添加
            $res = $this->model->insertDataGetId($this->parms);

            if ($res) {
               if (empty($this->join)) {
                   return message('新增成功',$this->model->getById(['id' => $res]),200);
               }
               $this->parms['id'] = $res;
               $this->insertLog();
               return [ 'msg' => '新增成功.','data' => $this->getBySelect()['data'][0],'code' => 200 ];
                
            }
            else{
                // $this->fail = true;
                return message('新增失败',[],500);
            }
        }

        public function update(){
            //改,分两种情况，普通修改和带有上传文件的修改,用是否设置上传文件来判断
            if(empty($this->upload)){
                $res = $this->updateNormal();
                return message($res['msg'],$res['data'],$res['code']);
            }

            $res = $this->updateHasUpload();
            return message($res['msg'],$res['data'],$res['code']);

        }

        public function delete($id){
            //删
            $res = $this->model->deleteData(['id' => $id]);
            if ($res) {
                $this->insertLog();
                return message('删除成功',null, 200);
            }
            else{
                // $this->fail = true;
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

            $sql.= MyWheres([ [$this->table.'.id' ,'=', 'id'] ]);

            if (!empty($this->group)) {
            //group 语句
                $sql.= MyGroup($this->group);
            }

            return getData($sql,[ 'id' => $this->parms['id']]);
        }

        public function upload(Request $request){
            //上传
              $file = $_FILES;
              //判断文件是否上传成功
              if (!$file){
                 return message('没有文件上传.',[],404);
              }
              $res = upload($file);
              if (!is_array($res)) {
                  return message($res,[],500);
              }
              return message('上传成功',$res,200);

        }

        public function updateHasUpload(){
            //修改，包含有上传文件的情况
            $parms = $this->parms;
            $where['where'] = ['id' => $parms['id']];

            $image_url_keys = $this->upload;
            //处理上传图片
            foreach ($parms as $k => $v) {
                if (in_array($k,$image_url_keys) && $v != '') {
                        if(preg_match("/\/uploads\/temp\/.+/", $v,$preg)){

                            $path = '/uploads/'.$k.'/';

                            $dir = $_SERVER['DOCUMENT_ROOT'].$path;//目录

                            if (!is_dir($dir)) {
                                mkdir($dir,0777,true);
                            }

                            $temp_file = $_SERVER['DOCUMENT_ROOT'].$preg[0];

                            $a = explode(' ', microtime());
                            $t = $a[1].($a[0]*1000000);//生成新的随机名字

                            $new_file = Auth::user()['id'].$t.'.'.explode('.', $preg[0])[1];//带上用户id防止重复并且更好识别

                            $old_file = $this->model->getValue(['id' => $parms['id']],$k);
                            if ($old_file) {
                                //说明存在旧文件
                                $old_file = $_SERVER['DOCUMENT_ROOT'].$old_file;
                                //需要先删除掉旧文件
                                @unlink($old_file);
                            }
                            copy($temp_file, ($dir.$new_file));//复制临时文件到新目录
                            @unlink($temp_file);//删除临时文件

                            $parms[$k] = $path.$new_file;

                        }
                        else{
                            unset($parms[$k]);
                        }
                }
            }
            unset($parms['id']);
            $where['update'] = $parms;

            $res = $this->model->updateData($where);

            if ($res) {

                if (empty($this->join)) {

                    return [ 'msg' => '修改成功.','data' => $this->model->getById(['id' => $this->parms['id']]),'code' => 200 ];
                }

                return [ 'msg' => '修改成功.','data' => $this->getBySelect()['data'][0],'code' => 200 ];

            }
            else{
                $this->fail = true;
                return [  'msg' => '修改失败.','data' => [],'code' => 500 ];
            }
        }

        public function updateNormal(){
            //改,没有上传文件的时候
            $parms = $this->parms;
            $where['where'] = ['id' => $parms['id']];

            unset($parms['id']);
            $where['update'] = $parms;

            $res = $this->model->updateData($where);

            if ($res) {
                $this->insertLog();
                if (empty($this->join)) {

                    return [ 'msg' => '修改成功.','data' => $this->model->getById(['id' => $this->parms['id']]),'code' => 200 ];
                }

                return [ 'msg' => '修改成功.','data' => $this->getBySelect()['data'][0],'code' => 200 ];

            }
            else{
                // $this->fail = true;
                return [  'msg' => '修改失败.','data' => [],'code' => 500 ];
            }
        }

        public function export(){
            //导出
            return Excel::download(new BaseExport($this->exportData()), '导出数据.xlsx');
        }

        public function exportData(){
            //导出数据
            $data = $this->getData(true)['data'];

            $data = isset($data['row'])?$data['row']:$data;
            //获取数据
            $export_data = [];
            array_push($export_data, array_values($this->export));

            foreach ($data as $k => $v) {
                //循环数据
                foreach ($this->export as $a => $b) {
                    //赋值，
                    $temp[] = $v->$a;
                }
                array_push($export_data,$temp);
                $temp = [];
            }

            return $export_data;
        }

        public function getLastSql(){
            return DB::getQueryLog();
        }

}
