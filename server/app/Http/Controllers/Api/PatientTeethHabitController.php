<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PatientTeethHabit;

class PatientTeethHabitController extends Controller
{
    public function index()
    {
        return message('',PatientTeethHabit::all());
    }

    public function show(PatientTeethHabit $patientTeethHabit)
    {
        return message('',$patientTeethHabit);
    }

    public function store(Request $request)
    {

        $habit=PatientTeethHabit::create($request->all());

        return message('',$habit);
    }

    public function update(Request $request , PatientTeethHabit $patientTeethHabit)
    {
        $patientTeethHabit->update($request->all());

        return message('',$patientTeethHabit, 200);
    }

    public function delete(PatientTeethHabit $patientTeethHabit)
    {
        $patientTeethHabit->delete();

        return message('',null, 200);
    }
}
