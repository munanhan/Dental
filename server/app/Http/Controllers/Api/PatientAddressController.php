<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PatientAddress;

class PatientAddressController extends Controller
{
    public function index()
    {
        return message('',PatientAddress::all());
    }

    public function show(PatientAddress $patientAddress)
    {
        return message('',$patientAddress);
    }

    public function store(Request $request)
    {

        $patientAddress=PatientAddress::create($request->all());

        return message('',$patientAddress);
    }

    public function update(Request $request ,PatientAddress $patientAddress)
    {
        $patientAddress->update($request->all());

        return message('',$patientAddress, 200);
    }

    public function delete(PatientAddress $patientAddress)
    {
        $patientAddress->delete();

        return message('',null, 200);
    }
}
