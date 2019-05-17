<?php
use Illuminate\Support\Facades\DB;

// /***
// * @param $parms
// * @return array(sql+parms)
// * @sql
// */
//     function getSql($parms,$table = '',$field = '*'){
//         //处理参数获取sql语句
//         $parms = array_filter($parms);//去除空

//         $unset_keys = function($keys = []) use ($parms){
//             //清除不需要的字段
//             foreach ($keys as $a => $b) {
//                 unset($parms[$b]);
//             }
//             return $parms;
//         };

//         $parms = isset($parms['_d'])?$unset_keys(['_d']):$parms;//得到最终参数集合

//         if (empty($parms) || $table == '') {
//             if ($field == '*') {
//                 return false;
//             }
//         }

//         $sql = 'select '.$field.' from '.$table.' where ';//组合sql语句

//         $end = count($parms);//结尾，用于判断不加and
//         $n = 0;//记录当前的所在的key位置
//         $m = 0;//in数据个数
//         foreach ($parms as $k => $v) {
//             //删除空和_d
//             $n++;
//             if ($k == 'dtfm') {
//                 $sql.=" `created_at` >= :dtfm";//时间
//             }
//             else if ($k == 'dtto') {
//                 $parms['dtto'] = $v.' 23:59:59';//把时间设置为当天最大
//                 $sql.=" `created_at` <= :dtto";
//             }
//             else if ($k == 'empty'){
//                 $sql.=" '1=1'";//空参数
//             }
//             else if (is_array($v)) {
//                 //处理特殊符号
//                 $type = key($v);
//                 switch ($type) {
//                     case 'in':
//                         // $parms[$k] = $v[$type];
//                         $in_str = '';
//                         $length = count($v['in'])-1;
//                         foreach ($v['in'] as $key => $value) {
//                             $in_str.= ":v$m";
//                             if ($key < $length) {
//                                 $in_str.=',';
//                             }
//                             $parms['v'.$m] = $value;
//                             $m++;
//                         }
//                         $sql.=" `$k` in($in_str)";
//                         // $sql.=" `$k` in(:$k)";

//                     break;
//                     case 'like':
//                         $parms[$k] = $v[$type];
//                         $sql.=" `$k` like :$k";
//                     break;
                    
//                 }
//                 // $sql.=" `$k` ".key($v).' '.$v[key($v)];
//                 // unset($parms[$k]);
//             }
//             else{
//                 $sql.=" `$k` = :$k";//其余普通字段处理
//             }
//             if ($n < $end) {
//                 //表示还没结尾，需要用and链接
//                 $sql.=" and ";
//             }
//         }
//         return ['sql' => $sql,'parms' => $parms];
//     }

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
 * check the parms 
   输入类型，字段集合，参数
   输出类型，错误信息或者false表示通过验证
 */
            function checkParms($fields,$parms){
                foreach ($fields as $k => $v) {
                    if (!array_key_exists($k,$parms) || $parms[$k] == '') {
                        return $v.'必填.';
                    }
                }
                return false;
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

                                    $val['children']=$child;
                                }                   
                            }
                            $val['level'] = $level;              
                            $tree[]=$val; 
                    }
                }   
                return $tree;
            }

