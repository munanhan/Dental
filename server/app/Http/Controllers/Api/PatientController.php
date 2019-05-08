<?php

namespace App\Http\Controllers\Api;

use App\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PatientController extends Controller
{

    public function index()
    {
        return message('',Patient::all());
    }

    public function show(Patient $patient)
    {
        return message('',$patient);
    }

    public function store(Request $request)
    {
        $year=now()->year;
        $moth=now()->month;
        $day=now()->day;

        dd($year,$moth,$day);

        $patient=Patient::create($request->all());

        return message('',$patient);
    }

    public function update(Request $request ,Patient $patient)
    {
        $patient->update($request->all());

        return message('',$patient, 200);
    }

    public function delete(Patient $patient)
    {
        $patient->delete();

        return message('',null, 200);
    }
}
