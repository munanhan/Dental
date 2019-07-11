<?php

namespace App\Http\Controllers\Api;

use App\Model\VisitItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VisitItemController extends BaseController
{
    public function store(Request $request)
    {

        $item=VisitItem::find(request('id'));

        if($item){
            $item->name=request('name');
            $item->name=request('days');
            $item->save();
        }else{
            $item=VisitItem::create($request->all());
        }

        return message('',$item);
    }
}
