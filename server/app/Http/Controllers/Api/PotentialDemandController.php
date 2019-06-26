<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PotentialDemand;

class PotentialDemandController extends BaseController
{

    public function store(Request $request)
    {
        $potentialDemand= PotentialDemand::find(request('id'));

        if($potentialDemand){
            $potentialDemand->name=request('name');
            $potentialDemand->save();
        }else{
            $potentialDemand=PotentialDemand::create($request->all());
        }

        return message('',$potentialDemand,200);
    }

}
