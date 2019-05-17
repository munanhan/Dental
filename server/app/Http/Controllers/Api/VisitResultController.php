<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\VisitResult;

class VisitResultController extends Controller
{
    public function index()
    {
        return message('',VisitResult::all());
    }

    public function show(VisitResult $result)
    {
        return message('',$result);
    }

    public function store(Request $request)
    {

        $result=VisitResult::create($request->all());

        return message('',$result);
    }

    public function update(Request $request , VisitResult $result)
    {
        $result->update($request->all());

        return message('',$result, 200);
    }

    public function delete(VisitResult $result)
    {
        $result->delete();

        return message('',null, 200);
    }
}
