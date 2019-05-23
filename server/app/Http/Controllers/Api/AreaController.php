<?php

namespace App\Http\Controllers\Api;

use App\Model\Area;
use App\Http\Controllers\Controller;

class AreaController extends Controller
{

    public function getProvince()
    {
        return message('',Area::select('id','area_code','area_name','parent_id','rank')->where('rank','1')->get());
    }

    public function getCityOrCountry()
    {
        return message('',Area::select('id','area_code','area_name','parent_id','rank')->where('parent_id',request('area_code'))->get());
    }

}
