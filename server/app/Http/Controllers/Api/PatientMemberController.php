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
        $member= PatientMember::find(request('id'));
        if($member){
            $member->name=request('name');
            $member->discount=request('discount');
            $member->save();
        }else{
            $member=PatientMember::create($request->all());
        }
        return message('',$member,'200');
    }

}
