<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Auth;

class ClinicController extends BaseController
{

	public function __construct(Request $request){
		$this->upload = [ 'logo','license_image_url','card_image_url' ];
		parent::__construct($request);
		if ($this->action == 'update') {
			//省市区设定
			!isset($this->parms['province_id'])?$this->parms['province_id'] = NULL:'';
			!isset($this->parms['city_id'])?$this->parms['city_id'] = NULL:'';
			!isset($this->parms['region_id'])?$this->parms['region_id'] = NULL:'';
		}
	}

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
