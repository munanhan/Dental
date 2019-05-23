<?php

namespace App\Http\Controllers\Api;

use App\Model\PatientCase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PatientCaseInfoController extends Controller
{
    public static function createCaseInfo(PatientCase $patientCase ,array $data)
    {
        return $patientCase->caseInfos()->create($data);
    }
}
