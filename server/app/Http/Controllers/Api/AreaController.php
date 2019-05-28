<?php

namespace App\Http\Controllers\Api;

use App\Model\Area;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;

class AreaController extends BaseController
{

    public function getProvince()
    {	//获取城市
    	$data = Area::select('id','area_code','area_name','parent_id','rank')->where('rank','1')->get();

        return message('成功',$data);
    }

    public function getCityOrCountry()
    {
        return message('成功',Area::select('id','area_code','area_name','parent_id','rank')->where('parent_id',request('area_code'))->get());
    }

    public function getById(){
    	//根据id获取

    	$data['province'] = $this->model->getData(['rank' => 1]);

    	$data['city'] = $this->model->getData(['parent_id' => $this->parms['province_id']]);

    	$data['country'] = $this->model->getData(['parent_id' => $this->parms['city_id']]);

    	return message('成功',$data,200);

    }


}
