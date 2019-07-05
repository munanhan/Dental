<?php

namespace App\Http\Controllers\Api;

use App\Model\VisitItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VisitItemController extends BaseController
{

    public function deleteById(Request $request)
    {
        $id=$request->all();

        dd($id);
        $visitItem=VisitItem::destroy($id);

        return message('',$visitItem);
    }
}
