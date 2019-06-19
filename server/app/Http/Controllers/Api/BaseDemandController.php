<?php

namespace App\Http\Controllers\Api;

use App\Model\BaseDemand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseDemandController extends Controller
{
    public function index()
    {
        return message('',BaseDemand::all());
    }

    public function show(BaseDemand $baseDemand)
    {
        return message('',$baseDemand);
    }

    public function store(Request $request)
    {
        $id=$request->all('id');

        $result=BaseDemand::where('id',$id)->first();

        if($result){
            BaseDemand::where('id',$id)->update($request->all());
            $baseDemand=BaseDemand::where('id',$id)->first();
        }else{
            $baseDemand=BaseDemand::create($request->all());
        }

        return message('',$baseDemand);
    }

    public function update(Request $request , BaseDemand $baseDemand)
    {
        $baseDemand->update($request->all());

        return message('',$baseDemand, 200);
    }

    public function delete(BaseDemand $baseDemand)
    {

        $baseDemand->delete();

        return message('',null, 200);
    }
}
