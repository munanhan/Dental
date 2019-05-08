<?php

namespace App\Http\Controllers\Api;

use App\Model\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PatientController extends Controller
{
    const SERIAL_NUMBER="serial.number:";

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

        $date=$this->getToday();
        dd($date);
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

    protected  function getToday()
    {
        return now()->format('Ymd');
    }

    protected  function generate()
    {
        $key=constant('SERIAL_NUMBER').$this->getToday();

    }
}
