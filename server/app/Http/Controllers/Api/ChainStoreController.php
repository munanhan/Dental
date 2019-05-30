<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Auth;

class ChainStoreController extends BaseController
{

	public function __construct(Request $request){
		$this->table = 'users';
		$this->join = [
						 'role_users' => 'role_users.user_id = users.id',
						 'roles' => 'role_users.role_id = roles.id',
						 'clinics' => 'clinics.id = users.clinic_id'
					  ];
		$this->field = 'users.id,users.name,users.phone,roles.name as role,is_admin,clinic_name';

		parent::__construct($request);
	}



}
