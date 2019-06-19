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
        $baseDemand= BaseDemand::find(request('id'));

        if($baseDemand){
            $baseDemand->name=request('name');
            $baseDemand->save();
        }else{
            $baseDemand=BaseDemand::create($request->all());
        }

        return message('',$baseDemand,200);
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
