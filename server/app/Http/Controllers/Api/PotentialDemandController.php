<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PotentialDemand;

class PotentialDemandController extends Controller
{
    public function index()
    {
        return message('',PotentialDemand::all());
    }

    public function show(PotentialDemand $potentialDemand)
    {
        return message('',$potentialDemand);
    }

    public function store(Request $request)
    {

        $id=$request->all('id');

        $result=BaseDemand::where('id',$id)->first();

        if($result){
            PotentialDemand::where('id',$id)->update($request->all());
            $potentialDemand=PotentialDemand::where('id',$id)->first();
        }else{
            $potentialDemand=PotentialDemand::create($request->all());
        }

        return message('',$potentialDemand);
    }

    public function update(Request $request , PotentialDemand $potentialDemand)
    {
        $potentialDemand->update($request->all());

        return message('',$potentialDemand, 200);
    }

    public function delete(PotentialDemand $potentialDemand)
    {
        $potentialDemand->delete();

        return message('',null, 200);
    }
}
