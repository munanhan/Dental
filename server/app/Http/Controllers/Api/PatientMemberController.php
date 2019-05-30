<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PatientMember;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Auth;

class PatientMemberController extends BaseController
{
<<<<<<< HEAD
    public function store(Request $request)
    {
        PatientMember::updateOrInsert(['id'=>request('id')],$request->all());
        return message('','','200');
    }
=======


>>>>>>> 4b235ec1e13e7c7224203564a1b76dc833a88133
}
