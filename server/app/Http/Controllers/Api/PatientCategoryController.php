<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PatientCategory;

class PatientCategoryController extends Controller
{
    public function index()
    {
        return message('',PatientCategory::all());
    }

    public function show(PatientCategory $patientCategory)
    {
        return message('',$patientCategory);
    }

    public function store(Request $request)
    {

        $patientCategory=PatientCategory::create($request->all());

        return message('',$patientCategory);
    }

    public function update(Request $request , PatientCategory $patientCategory)
    {
        $patientCategory->update($request->all());

        return message('',$patientCategory, 200);
    }

    public function delete(PatientCategory $patientCategory)
    {
        $patientCategory->delete();

        return message('',$patientCategory, 200);
    }
}
