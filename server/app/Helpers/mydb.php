<?php
use Illuminate\Support\Facades\DB;

/***
 * 处理参数
 * 获取类型(数组) 即为前端传过来的参数集合
 * 返回类型(数组)'parms' => 参数,'date' => 日期时间,'pager' => 分页参数
 */ 
           function getParms($parms){
            //处理参数
            // dd($parms);
                $parms = array_filter($parms,function($v){return $v !== null;});//去除空
                $field = ['_d','dtfm','dtto','current_page','page_size'];//清除的字段(不需要进入数据库搜索的字段单独处理)

                $date['dtfm'] = isset($parms['dtfm'])?$parms['dtfm']:0;
                $date['dtto'] = isset($parms['dtto'])?$parms['dtto'].' 23:59:59':date('Y-m-d').' 23:59:59';//日期

                $pager['current_page'] = isset($parms['current_page'])?$parms['current_page']:'';
                $pager['page_size'] = isset($parms['page_size'])?$parms['page_size']:'';//分页参数

                $unset_keys = function($parms = []) use ($field){
                    //清除不需要的字段
                    foreach ($parms as $k => $v) {
                        if(in_array($k, $field)){
                            unset($parms[$k]);
                        }
                    }
                    return empty($parms)?[]:$parms;
                };

                return ['parms' => $unset_keys($parms),'date' => $date,'pager' => $pager];//得到最终参数集合

           } 
/***
 * 处理sql
 * 输入类型 字符串，(sql，参数，分页选项)
 * 返回类型 数组，(数据，说明，状态码)         
 */         function getData($sql,$parms,$pager = 0){
                //获取查询数据
                try{
                    //$pager决定分页与否
                    return $pager == 1?
                    ['data' => [ 'row' => DB::select($sql,$parms)],'msg' => '成功','code' => 200]:
                    [ 'data' => DB::select($sql,$parms),'msg' => '成功','code' => 200 ];
                }catch(\Exception $e){
                    dd($e->getMessage());
                    return [ 'data' => [],'msg' => '异常','code' => 500 ];
                }
            }

/***
 * 类型转换，sql case then
 * 输入类型，数组 $parms => (表名，字段名，别名，数据源)
 * 返回类型，字符串 $case => 完整的case then 语句
 */

            function caseThen($parms){
                //case then
                $return_error = function($parms){
                    return '缺少'.$parms;//缺少数据
                };
                $data = isset($parms['data'])?$parms['data']:$return_error('data');
                $table = isset($parms['table'])?$parms['table']:$return_error('table');
                $field = isset($parms['field'])?$parms['field']:$return_error('field');
                $as = isset($parms['as'])?$parms['as']:$field;

                $case = "(case $table.$field";//case
                foreach ($data as $k => $v) {
                    $case.=" when '$k' then '$v'";
                }
                $case.= " end )'$as'";
                return $case;
            }

/***
 * sql for limit
 * 输入类型，数组 $parms => (current_page分页当前页，page_size总页数)
 * 返回类型，字符串 $sql 完整的limit语句
 */         
            function MyLimit($parms){
                //limit
                $return_error = function($parms){
                    return '缺少'.$parms;//缺少数据
                };
                $current_page = isset($parms['current_page'])?$parms['current_page']:1;
                $page_size = isset($parms['page_size'])?$parms['page_size']:$return_error('page_size');

                return ' limit '.($current_page-1)*($page_size).','.$page_size;
            }

/***
 * sql for where
 * 输入类型，数组 $parms => where参数集合
 * 返回类型，字符串 $where 完整的where语句
 */
            function MyWhere($parms){
                //where
                if (empty($parms)) {
                    return ' ';//无参数
                }
                $length = count($parms)-1;//长度
                $n = 0;//计数
                $where = ' where';

                foreach ($parms as $k => $v) {
                    if (is_array($v)) {
                        $where.= ' '.$v[0].' '.$v[1].' :'.preg_replace("/\w+\./",'',$v[0]);
                    }
                    else{
                        $where.= " $k = :".preg_replace("/\w+\./",'',$k);
                    }
                    
                    $n < $length?$where.=' and':'';
                    $n++;
                }

                return $where;
            }

/***
 * sql for where MyWhere的升级版，保留旧方法防止之前的代码废弃
 * 输入类型，数组 $parms => where参数集合,处理where => 关联 参数parm的处理
 * 例子，where [ 'field' => 'parms_field' ], parms [ 'parms_field' => 'parms_value' ]
 * 返回类型，字符串 $where 完整的where语句
 */
            function MyWheres($parms){
                //where
                if (empty($parms)) {
                    return ' ';//无参数
                }
                $length = count($parms)-1;//长度
                $n = 0;//计数
                $where = ' where';

                foreach ($parms as $k => $v) {
                    if (is_array($v)) {
                        $where.= ' '.$v[0].' '.$v[1].' :'.$v[2];
                    }
                    else{
                        $where.= " $k = :".$v;
                    }
                    
                    $n < $length?$where.=' and':'';
                    $n++;
                }

                return $where;
            }

/***
 * sql for select 
 * 输入类型，数组集合 $parm => 字段集合,表
 * 返回类型，字符串 $select 完整的select语句
 */
            function MySelect($parms = []){
                //select
                $select = 'select '.(empty($parms['field'])?'* ':'');
                // $field = implode('`,`',$parms['field']);
                // $select.= '`'.$field.'`'.' from '.$parms['table'];
                // $select = str_replace('`(','(',$select);//case then 处理`
                // $select = str_replace("'`","'",$select);
                $field = is_array($parms['field'])?implode(',',$parms['field']):$parms['field'];

                $select.= $field.' from '.$parms['table'];
                return $select;
            }
/***
 * sql for join
 * 输入类型，表集合 $tables => ($k=> 表名 ,$v => 条件)
 * 返回类型 $join 完整的join语句
 */
            function MyJoin($tables,$join = 'inner'){
                //join
                $return_error = function($parms){
                    return '缺少'.$parms;//缺少数据
                };
                $tables = isset($tables)?$tables:$return_error('tables');
                $sql = '';
                foreach ($tables as $k => $v) {
                       $sql.= " $join join ".$k.' on '.$v;
                }
                return $sql;
            }

/***
 * sql for order by
 * 输入类型，order集合
 * 返回类型，完整的order语句
 */   
            function MyOrder($parms){
                //order by
                $order_by = '';
                $length = count($parms)-1;//长度
                $n = 0;//计数
                foreach ($parms as $k => $v) {
                    $order_by.= ' order by '.$k.' '.$v;
                    $n < $length?$order_by.=',':'';
                    $n++;
                }
                return $order_by;
            }

/***
 * sql for group by
 * 输入类型，group_by集合
 * 返回类型，完整的group_by语句
 */   
            function MyGroup($parms){
                //order by
                return is_array($parms)?' group by '.implode(',',$parms):' group_by '.$parms;
            }

/***
 * sql for having
 * 输入类型，having集合
 * 返回类型，完整的having语句
 */   
            function MyHaving($parms){
                //order by
                if(empty($parms)){
                    return ' ';
                }
                $having = ' having';
                $length = count($parms)-1;//长度
                $n = 0;//计数
                foreach ($parms as $k => $v) {
                    $having.= is_array($v)?' '.$v[0].' '.$v[1].' :'.$v[2]:' '.$k.' = '.$v;
                    $n < $length?$having.=' and ':'';
                    $n++;
                }
                return $having;
            }

/***
 * check the parms 
   输入类型，字段集合，参数
   输出类型，错误信息或者false表示通过验证
 */
            function checkParms($fields,$parms){
                if (empty($fields)) {
                    return false;
                }
                $field = '';
                //字段
                foreach ($fields as $k => $v) {
                    $rule = explode('|',$v);
                    //规则
                    foreach ($rule as $a => $b) {
                        $rule_children = explode(':',$b);
                        switch ($rule_children[0]) {
                            case 'unique':
                                $field = $rule_children[1];
                                //记录字段
                                if (!array_key_exists($k,$parms) || $parms[$k] == '') {
                                    return $field.'必填.';
                                }
                                break;
                            case 'normal':
                                $field = $rule_children[1];
                                break;
                            case 'min':
                                if ($parms[$k] < $rule_children[1]) {
                                    return $field.'不能小于'.$rule_children[1].'.';
                                }
                                break;
                            case 'max':
                                if ($parms[$k] > $rule_children[1]) {
                                    return $field.'不能大于'.$rule_children[1].'.';
                                }
                                break;                            
                            case 'type':
                                $res = checkType($rule_children[1],$parms[$k]);
                                if ($res) {
                                    return $field.$res;
                                }
                                break;
                        }
                    }
                }
                return false;
            }

/* 检验类型
 * 输入类型，值
 * 返回检验结果true or false
 */
            function checkType($type,$value){
                //检验类型
                switch ($type) {
                    case 'int':
                        //是否整数
                        $is_int = preg_match("/^\d+$/", $value);
                        return $is_int == true?false:'只能输入整数.';
                        break;
                    case 'float':
                        //是否为浮点型
                        return is_float($value) == true?false:'只能输入浮点.';
                        break;
                    case 'bool':
                        //是否威布尔
                        return is_bool($value) == true?false:'只能输入布尔类型.';
                        break;
                    case 'string':
                        //是否为字符串
                        return is_string($value) == true?false:'只能输入字符串.';
                        break;
                    case 'array':
                        //是否为数组
                        return is_array($value) == true?false:'只能输入数组.';
                        break;
                    case 'object':
                        //是否为对象
                        return is_object($value) == true?false:'只能输入对象.';
                        break;
                    case 'null':
                        //是否为空
                        return is_null($value) == true?false:'只能输入空.';
                        break;
                    case 'resource':
                        //是否为资源
                        return is_resource($value) == true?false:'只能输入资源.';
                        break;
                    case 'scalar':
                        //是否标量
                        return is_scalar($value) == true?false:'只能输入标量.';
                        break;
                    case 'number':
                        //是否数字
                        return is_numeric($value) == true?false:'只能输入数字.';
                        break;
                    case 'function':
                        //是否为函数
                        return is_callable($value) == true?false:'只能输入函数.';
                        break;
                }
            }
/***
 * where parms
 * 输入类型，where参数集合
 * 输出类型，返回一个可用的where参数
 */     
            function dbParms($parms){
                //dbParms
                $new_parms = [];
                foreach ($parms as $k => $v) {
                    if ($v[1] == 'like') {
                        $new_parms[$v[0]] = '%'.$v[2].'%';
                        continue;
                    }
                    $new_parms[$v[0]] = $v[2];
                }
                return $new_parms;
            }

/**
  *获取树结构
  */
            function getTree($list,$pk='id',$pid='p_id',$child='children',$root=0,$level=1){
                $tree=array();
                foreach($list as $key=> $val){

                    if($val[$pid]==$root){
                        //获取当前$pid所有子类 
                            unset($list[$key]);
                            if(! empty($list)){
                                $child=getTree($list,$pk,$pid,$child,$val[$pk],$level+1);
                                if(!empty($child)){

                                    $val['children'] = $child;
                                }
                                else{
                                    $val['children'] = [];
                                }                   
                            }
                            $val['level'] = $level;              
                            $tree[]=$val; 
                    }
                }   
                return $tree;
            }

/**
  *检测更新时间，防止同一时间多个用户修改同一条信息被覆盖
  */
            function checkUpdateTime($parms){
                    //检测更新时间
                $updated_at = DB::table($parms['table'])
                                ->where('id',$parms['id'])
                                ->value('updated_at');
                if ($updated_at != $parms['updated_at']) {
                    return true;
                }
                return false;
            }

/**
 * 上传方法
 */
            function upload($file){
                //上传
                $key = key($file);//获取key

                $name = $file[$key]['name'];//文件名

                $ext = substr(strrchr($name, '.'), 1);//获取文件后缀

                $check = checkExt($ext);
                if ($check) {
                    return $check; 
                }

                $tmp_file = $file[$key]['tmp_name'];//零时文件

                $size = $file[$key]['size'];//文件大小

                $path = '/uploads/temp/';

                $temp_dir = $_SERVER['DOCUMENT_ROOT'].$path;//临时目录

                if (!is_dir($temp_dir)) {
                    mkdir($temp_dir,0777,true);
                }

                $a = explode(' ', microtime());
                $t = $a[1].($a[0]*1000000);
                $new_name = $t.'.'.($ext);//新的文件名，随机名字

                if(move_uploaded_file($tmp_file,$temp_dir.$new_name)){
                    return [ $key => $path.$new_name ];
                }
                return '上传失败';      
            }

/*
 * 检测后缀名
 */
            function checkExt($ext){
                //检测后缀
                $ext_arr = ['jpg','jpeg','png'];
                if (in_array($ext, $ext_arr)) {
                    return false;
                }
                return '图片后缀名必须为jpg,jpeg,png的任一种.';
            }