<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PatientAnamnesis;

class PatientAnamnesisController extends Controller
{
    public function index()
    {
        return message('',PatientAnamnesis::all());
    }

    public function show(PatientAnamnesis $anamnesis)
    {
        return message('',$anamnesis);
    }

    public function store(Request $request)
    {

        $anamnesis=PatientAnamnesis::create($request->all());

        return message('',$anamnesis);
    }

    public function update(Request $request , PatientAnamnesis $anamnesis)
    {
        $anamnesis->update($request->all());

        return message('',$anamnesis, 200);
    }

    public function delete(PatientAnamnesis $anamnesis)
    {
        $anamnesis->delete();

        return message('',null, 200);
    }
}
