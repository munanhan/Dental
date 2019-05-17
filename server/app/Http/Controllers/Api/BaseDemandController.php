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

    public function show(BaseDemand $consult)
    {
        return message('',$consult);
    }

    public function store(Request $request)
    {

        $consult=BaseDemand::create($request->all());

        return message('',$consult);
    }

    public function update(Request $request , BaseDemand $consult)
    {
        $consult->update($request->all());

        return message('',$consult, 200);
    }

    public function delete(BaseDemand $consult)
    {
        $consult->delete();

        return message('',null, 200);
    }
}
