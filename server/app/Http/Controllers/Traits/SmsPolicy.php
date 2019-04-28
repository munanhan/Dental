<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/26
 * Time: 15:48
 */

namespace App\Http\Controllers\Traits;
use Illuminate\Support\Facades\Redis;


Trait SmsPolicy
{
    protected function setPolicy($phone)
    {
        if(Redis::exists($this->minKey($phone)) || Redis::get($this->dayKey($phone)) >10 ){
            return false;
        }

        Redis::set($this->minKey($phone),1);
        Redis::incr($this->dayKey($phone));

        return true;
    }

    protected function minKey($phone)
    {
        return 'min：' . date('YmdHi') . ':' . $phone;
    }

    protected function dayKey($phone)
    {
        return 'day:' . date('YmdH') . ':' . $phone;
    }
}