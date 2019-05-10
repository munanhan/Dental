<?php
use Illuminate\Support\Facades\DB;
/***
 * @param string $msg
 * @param array $data
 * @param int $statusCode=200
 * @return \Illuminate\Http\JsonResponse
 */
    function message($msg='',$data=[],$statusCode=200)
    {
        return response()->json(['msg'=>$msg,'data'=>$data],$statusCode);
    }

/***
 * @return string  return six random numbers
 */
    function sixRandom()
    {
        $length=6;
        $chars='0123456789';
        $code='';
        while (mb_strlen($code)<$length){
            $code .=mb_substr($chars,(mt_rand() % mb_strlen($chars)),1);
        }
        return $code;
    }

/***
 * @param $phone
 * @return bool
 */
    function isPhone($phone)
    {
        if(preg_match('/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|(147))\\d{8}$/',$phone)){
            return true;
        }

        return false;
    }

/***
 * @param $email
 * @return bool
 */
    function isEmail($email)
    {
        if(preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/',$email)){
            return true;
        }

        return false;
    }

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
 */ 
           function getParms($parms){
            //处理参数
                $parms = array_filter($parms);//去除空

                $field = ['_d','dtfm','dtto'];//清除的字段

                $date['dtfm'] = isset($parms['dtfm'])?$parms['dtfm']:0;
                $date['dtto'] = isset($parms['dtto'])?$parms['dtto'].' 23:59:59':date('Y-m-d').' 23:59:59';

                $unset_keys = function($parms = []) use ($field){
                    //清除不需要的字段
                    foreach ($parms as $k => $v) {
                        if(in_array($k, $field)){
                            unset($parms[$k]);
                        }
                    }
                    return empty($parms)?[]:$parms;
                };

                return ['parms' => $unset_keys($parms),'date' => $date];//得到最终参数集合

           } 
/***
 *处理sql
 *          
 */         function getData($sql,$parms,$pager = 0){
                //获取查询数据
                try{
                    return $pager == 1?
                    ['data' => [ 'row' => DB::select($sql,$parms)],'msg' => '成功','code' => 200]:
                    [ 'data' => DB::select($sql,$parms),'msg' => '成功','code' => 200 ];
                }catch(\Exception $e){
                    return [ 'data' => [],'msg' => '异常','code' => 500 ];
                }
            }