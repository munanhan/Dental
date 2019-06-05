<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Auth;
       
class PrivilegeController extends BaseController
{

	public function getByType(){
		//获取平台权限
		if (!isset($this->parms['role_id'])) {
			return message('没有选中角色',[],404);
		}
		$data = $this->model->where('type',$this->parms['type'])->get();
		$data = getTree($data,'id','parent_id');//所有权限

		$role_privilege = $this->getRolePrivilege();

		return message('成功',[ 'privilege' => $data,'role_privilege' => $role_privilege ] ,200);
	}

	public function getRolePrivilege(){
		//角色权限
		$sql = "select a.id from `privileges` a INNER JOIN privilege_roles b on a.id = b.privilege_id INNER JOIN roles c on b.role_id = c.id INNER JOIN role_users d on c.id = d.role_id INNER JOIN users e on d.user_id = e.id where b.role_id = ?";

		$res = getData($sql,[$this->parms['role_id']]);

		return array_column($res['data'],'id');

	}
}
