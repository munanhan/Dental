<?php

namespace App\Http\Controllers\Api;

use App\Model\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use App\Model\PatientInfo;

class PatientInfoController extends Controller
{
    public static function createPatientInfo(Patient $patient ,array $data)
    {
        $patients=Schema::getColumnListing('patients');

        foreach ($patients as $key){
            array_key_exists($key,$data);
            unset($data[$key]);
        }

        return $patient->patientInfo()->create($data);
    }
}
