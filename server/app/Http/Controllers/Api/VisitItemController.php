<?php

namespace App\Http\Controllers\Api;

use App\Model\VisitItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VisitItemController extends Controller
{
    public function index()
    {
        return message('',VisitItem::all());
    }

    public function show(VisitItem $visitItem)
    {
        return message('',$visitItem);
    }

    public function store(Request $request)
    {

        $data=$request->all()['visit'];

        foreach ($data as $key =>$value)
        {
             VisitItem::create($value);
        }

        $visitItem=VisitItem::all();

        return message('',$visitItem);
    }

    public function update(Request $request,VisitItem $visitItem)
    {
        $visitItem->update($request->all());
        return message('',$visitItem);
    }

    public function delete(VisitItem $visitItem)
    {
        $visitItem->delete();
        return message('',$visitItem);
    }

    public function deleteById(Request $request)
    {
        $id=$request->all();

        dd($id);
        $visitItem=VisitItem::destroy($id);

        return message('',$visitItem);
    }
}
