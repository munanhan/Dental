<?php

namespace App\Http\Controllers\Api;

use App\Model\BaseDemand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class BaseDemandController extends BaseController
{

    public function show(BaseDemand $baseDemand)
    {
        return message('',$baseDemand);
    }

    public function store(Request $request)
    {
        $baseDemand= BaseDemand::find(request('id'));

        if($baseDemand){
            $baseDemand->name=request('name');
            $baseDemand->save();
        }else{
            $baseDemand=BaseDemand::create($request->all());
        }

        return message('',$baseDemand,200);
    }

}
