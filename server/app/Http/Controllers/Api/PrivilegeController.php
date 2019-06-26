<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Model\Role;
use Illuminate\Support\Facades\Redis;
       
class PrivilegeController extends BaseController
{
	public function __construct(Request $request){

		$action = explode('@',\Route::current()->getActionName());

		$this->table = $action[1] == 'update'?'privilege_roles':'';

		parent::__construct($request);
	}

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
		$sql = "select a.id from `privileges` a INNER JOIN privilege_roles b on a.id = b.privilege_id INNER JOIN roles c on b.role_id = c.id where b.role_id = ?";

		$res = getData($sql,[$this->parms['role_id']]);

		return array_column($res['data'],'id');

	}

	public function update(){

		$set_permission = function($role_id,$privilege = 0){
			$this->model->deleteData(['role_id' => $role_id]);
			//删除旧权限
			$permission = [];
			if ($privilege != 0) {
				foreach ($privilege as $k => $v) {
					$permission[$k]['role_id'] = $role_id;
					$permission[$k]['privilege_id'] = $v;
				}
			}

			if(!$this->model->insertData($permission)){
				return false;
			}
			return true;
		};

		$res = isset($this->parms['privilege'])?
			   $set_permission($this->parms['role_id'],$this->parms['privilege']):
			   $set_permission($this->parms['role_id']);

		if (!$res) {
			return message('设置失败',null,500);
		}
		return message('设置成功',null,200);
	}

	public function getUserPrivilege(){

		//获取个人权限
		$user = Auth::user();

		if ($user['is_admin'] == 1) {
			//超级管理员无视权限，直接取所有
			$data = $this->model->get()->toArray();
		}
		else{
			$sql = "select a.* from `privileges` a INNER JOIN privilege_roles b on a.id = b.privilege_id INNER JOIN roles c on b.role_id = c.id INNER JOIN role_users d on c.id = d.role_id INNER JOIN users e on d.user_id = e.id  where e.id = ?";

			$res = getData($sql,[$user['id']]);
			$data = $res['data'];
		}

        $privilegeList = serialize(array_filter(array_column($data, 'module')));

		Redis::set('user_auth'.$user['id'],$privilegeList);

		//用户权限
		return message('成功',$data,200);
	}
}
