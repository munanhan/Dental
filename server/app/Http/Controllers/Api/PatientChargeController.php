<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/21
 * Time: 16:41
 */

namespace App\Http\Controllers\Api;

//收费
class PatientChargeController extends BaseController
{
    public function show()
    {
        return message('',request('id'),200);
    }

    public function store()
    {
        
    }
}