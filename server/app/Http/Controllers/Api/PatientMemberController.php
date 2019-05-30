<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PatientMember;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Auth;

class PatientMemberController extends BaseController
{
    public function store(Request $request)
    {
        PatientMember::updateOrInsert(['id'=>request('id')],$request->all());
        return message('','','200');
    }
}
