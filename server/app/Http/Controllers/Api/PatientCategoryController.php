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

    public function show(PatientCategory $category)
    {
        return message('',$category);
    }

    public function store(Request $request)
    {

        $category=PatientCategory::create($request->all());

        return message('',$category);
    }

    public function update(Request $request , PatientCategory $category)
    {
        $category->update($request->all());

        return message('',$category, 200);
    }

    public function delete(PatientCategory $category)
    {
        $category->delete();

        return message('',null, 200);
    }
}
