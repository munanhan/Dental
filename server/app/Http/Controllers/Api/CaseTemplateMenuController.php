<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Auth;
       
class CaseTemplateMenuController extends BaseController
{


	public function index(){
		$data = $this->model->get();
		return message('成功',getTree($data),200);
	}

}
