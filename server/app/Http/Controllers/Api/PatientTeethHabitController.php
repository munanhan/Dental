<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PatientTeethHabit;

class PatientTeethHabitController extends BaseController
{

    public function show(PatientTeethHabit $patientTeethHabit)
    {
        return message('',$patientTeethHabit);
    }

    public function store(Request $request)
    {

        $habit=PatientTeethHabit::find(request('id'));

        if($habit){
            $habit->name=request('name');
            $habit->save();
        }else{
            $habit=PatientTeethHabit::create($request->all());
        }

        return message('',$habit);
    }

}
