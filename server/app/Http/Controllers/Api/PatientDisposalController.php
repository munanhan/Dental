<?php

namespace App\Http\Controllers\Api;

use App\Model\Disposal;
use App\Model\CostCategory;
use Illuminate\Http\Request;

//处置记录
class PatientDisposalController extends BaseController
{

    /*
     * 返回所有处置和药品列表
     */
    public function index()
    {
        return message('',Disposal::all(),200);
    }

    /*
     *
     */
    public function show()
    {
        return message('',[],200);
    }

    /*
     *
     */
    public function store(Request $request)
    {
        $patientDisposal['patient_id']=request('patient_id');
        $patientDisposal['disposal_date']=request('disposal_date');

        return message('',$patientDisposal,200);
    }

    /*
     * 返回处置类型列表
     */
    public function categories()
    {
        return message('',CostCategory::all(['id','category']),200);
    }


}
