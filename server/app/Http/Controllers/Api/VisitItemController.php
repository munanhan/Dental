<?php

namespace App\Http\Controllers\Api;

use App\Model\VisitItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $visitItem=VisitItem::create($request->all());

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
}
