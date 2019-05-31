<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\BaseModel;
use Illuminate\Support\Facades\Auth;
use App\Model\OperationLog;
use Illuminate\Support\Facades\Storage;

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
        protected $controller = '';
        //控制器
        protected $action = '';
        //方法
        protected $fail = false;
        //执行是否的方法
        protected $upload = [];
        //用于判断是否有上传文件

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

                $this->controller = $table = str_replace('Controller','s',$preg[0]);

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

            $this->model = new BaseModel($this->table);
            //实例化

        }

        public function __destruct(){
            //销毁事件,自动写入日志
            if (!$this->fail) {
                //判断写入是否失败，成功则插入日志
                //日志写入部分
                //要是用这个功能需要去config文件里面添加对应的模块以及名称，模块key为对应的表名，value为模块名称
                $_log = [ 'addData' => '添加', 'delete' => '删除','update' => '修改' ];
                $module = config('config.module.'.$this->table);
                //模块

                if ($module && array_key_exists($this->action, $_log) ) {
                    //日志
                    $log = [ 'operation_type' => $_log[$this->action],
                             'operation_content' => Auth::user()['name'].$_log[$this->action].'了一条'.$module.'数据',
                             'module' => $module,
                             'created_by' => Auth::user()['name'],
                             'created_at' => date('Y-m-d H:i:s')
                           ];

                    OperationLog::insert($log);
                }
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
                $total = $this->model->getCount($this->parms);
                $res = getData($sql,$this->parms);
                return message($res['msg'],[ 'row' => $res['data'],'total' => $total ],$res['code']);
            }

            $res = getData($sql,$this->parms);

            return message($res['msg'],$res['data'],$res['code']);

        }

        public function getById(){
            //get by id
            // $data = empty($this->join)?$this->model->getById(['id' => $this->parms['id']]):$this->getBySelect()['data'][0];
            $data = $this->model->getById(['id' => $this->parms['id']]);
            if ($data) {
                return message('获取成功',$data,200);
            }
            return message('获取失败',[],500);
            
        }

        public function addData(){
            //添加
            $res = $this->model->insertDataGetId($this->parms);

            if ($res) {
               
                return message('新增成功',$this->model->getById(['id' => $res]),200);
            }
            else{
                $this->fail = true;
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

                return message('删除成功',null, 200);
            }
            else{
                $this->fail = true;
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

}
