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

        // return message('成功',Area::select('id','area_code','area_name','parent_id','rank')->where('parent_id',$this->parms['area_code'])->get());

        return message('成功',$this->model->getData(['parent_id' => $this->parms['area_code']]),200);
    }

    public function getById(){
    	//根据id获取

    	$data['province'] = $this->model->getData(['rank' => 1]);

    	$data['city'] = isset($this->parms['province_id'])?$this->model->getData(['parent_id' => $this->parms['province_id']]):[];

    	$data['country'] = isset($this->parms['city_id'])?$this->model->getData(['parent_id' => $this->parms['city_id']]):[];

    	return message('成功',$data,200);

    }


}
