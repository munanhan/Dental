<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Auth;

class ClinicController extends BaseController
{

	public function getClinic(){

		$field = [ 'company_name',
				   'clinic_name',
				   'clinics.contact',
				   'clinics.phone',
				   'clinics.email',
				   'clinics.address',
				   
				    ];

		$data = $this->model
			 ->leftJoin('companies','clinics.company_id','=','companies.id')
			 ->where('clinics.id','=',Auth::user()['clinic_id'])
			 ->first($field);

		if ($data) {
			return message('成功',$data,200);
		}
		return message('失败',new stdClass(),500);
	}

}
