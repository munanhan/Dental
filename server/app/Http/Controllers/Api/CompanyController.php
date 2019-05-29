<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Auth;

class CompanyController extends BaseController
{

		public function __construct(Request $request){
			$this->upload = [ 'company_logo' ];
			parent::__construct($request);
			if ($this->action == 'update') {
				//省市区设定
				!isset($this->parms['province_id'])?$this->parms['province_id'] = NULL:'';
				!isset($this->parms['city_id'])?$this->parms['city_id'] = NULL:'';
				!isset($this->parms['region_id'])?$this->parms['region_id'] = NULL:'';
			}
		}
        public function getById(){
            //get by id
            // $data = empty($this->join)?$this->model->getById(['id' => $this->parms['id']]):$this->getBySelect()['data'][0];
            $data = $this->model->getById(['id' => Auth::user()['company_id']]);
            if ($data) {
            	return message('获取成功',$data,200);
            }
            else{
            	return message('获取失败',[],500);
            }
            
        }

}
