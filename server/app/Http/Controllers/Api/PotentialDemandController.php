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

    public function show(PotentialDemand $consult)
    {
        return message('',$consult);
    }

    public function store(Request $request)
    {

        $consult=PotentialDemand::create($request->all());

        return message('',$consult);
    }

    public function update(Request $request , PotentialDemand $consult)
    {
        $consult->update($request->all());

        return message('',$consult, 200);
    }

    public function delete(PotentialDemand $consult)
    {
        $consult->delete();

        return message('',null, 200);
    }
}
