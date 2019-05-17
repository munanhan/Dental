<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\VisitContent;

class VisitContentController extends Controller
{
    public function index()
    {
        return message('',VisitContent::all());
    }

    public function show(VisitContent $content)
    {
        return message('',$content);
    }

    public function store(Request $request)
    {

        $content=VisitContent::create($request->all());

        return message('',$content);
    }

    public function update(Request $request , VisitContent $content)
    {
        $content->update($request->all());

        return message('',$content, 200);
    }

    public function delete(VisitContent $content)
    {
        $content->delete();

        return message('',null, 200);
    }
}
