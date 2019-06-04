<?php

namespace App\Http\Middleware;
use App\Model\OperationLog;
use Illuminate\Support\Facades\Auth;

use Closure;

class BaseVerifyFields
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   

        $fields = config($request->attributes->get('config_load'));

        $parms = getParms($request->all())['parms'];
        //参数

        if ($fields == '') {
            switch ($request->attributes->get('action')) {
                case 'delete':
                    $fields = config('CommonDelete');
                    break;
                
                case 'update':
                    $controller = $request->attributes->get('controller');
                    $fields = config('verify_fields.'.$controller.'.addData');
                    $fields['id'] = 'unique:id|type:int';
                    break;
                case 'getById':
                    $fields = config('CommonGetById');
                    break;  
            }
        }


        $res = checkParms($fields,$parms);
        //更新时间判断部分
        if(isset($parms['id']) && isset($parms['updated_at'])){
            $where = [
                        'table' => $request->attributes->get('table'),
                        'id' => $parms['id'],
                        'updated_at' => $parms['updated_at']
                     ];

            if(checkUpdateTime($where)){

                return message('该数据已被修改，请刷新.',[],500);

            }

        }
        //字段验证部分
        if ($res) {
            return message($res,[],404);
        }


        return $next($request);
    }
}
