<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

//处置记录
class PatientDisposalController extends BaseController
{

    public function show()
    {
        return message('',request('id'),200);
    }

    public function store(Request $request)
    {
        $patientDisposal['patient_id']=request('patient_id');
        $patientDisposal['disposal_date']=request('disposal_date');

        return message('',$patientDisposal,200);
    }

}
