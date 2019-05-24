<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Model\User;
use App\Model\Role;
use App\Model\RoleUser;
use Illuminate\Support\Facades\Auth;

class StaffController extends BaseController
{

    public function __construct(Request $request){
        $this->table = 'users';
        parent::__construct($request);
    }

    public function userList(){
        //员工列表
        $parms = $this->parms;
        // $data = User::where($where)->get();
        $case = [ //case
                    'data' => [ 0 => '离职',1 => '在职'],
                    'table' => 'users',
                    'field' => 'entry',
                ];
        $select = [//select
                    'table' => 'users',
                    'field' => ['users.id,users.name,entry,phone','roles.name as role',caseThen($case)] 
                  ];   
        $join = [//join
                    'role_users' => 'role_users.user_id = users.id',
                    'roles' => 'roles.id = role_users.role_id'
                ];
        $where = isset($parms['name'])?['users.name' => $parms['name']]:[];//where
        $order = [//order
                    'id' => 'desc'
                 ];

        $sql = MySelect($select).MyJoin($join).MyWhere($where).MyOrder($order);//sql

        $res = getData($sql,$parms);

        return message($res['msg'],$res['data'],$res['code']);
    }

    public function getRole(){
        //获取角色
        return message('成功', Role::where('id','>',1)->get(['id','name']), 200);

    }

    public function addData(){
        //添加用户
        $fields = [ 'phone' => '电话',
                    'password' => '密码',
                    'name' => '姓名',
                    'role_id' => '角色'
                  ];//必填字段

        $parms = $this->parms;
        $res = checkParms($fields,$parms);//验证字段信息

        if ($res) {
            //字段验证不通过
            return message($res,[],500);
        }

        $find = User::where('phone',$parms['phone'])->first();
        if ($find) {
            // return message('用户已存在',[],500);
        }
        $role['role_id'] = $parms['role'];
        unset($parms['role']);
        $parms['password'] = bcrypt($parms['password']);
        $data = User::create($parms);

        $role['user_id'] = $data['id'];

        $data2 = RoleUser::create($role);
        if ($data && $data2) {
            return message('成功', [], 200);
        }
        else{
            return message('失败', [], 500);
        }
    }

    public function delete($id)
    {
        $res = User::destroy($id);
        $res2 = RoleUser::where('user_id',$id)->delete();
        if ($res & $res2) {
            return message('删除成功',null, 200);
        }
        else{
            return message('删除失败',null, 500);
        }        
    }

    public function updatePassword(){
        //修改密码
        $fields = [ 'password' => '新密码',
                    're_password' => '确认密码',
                    'id' => 'id'
                  ];
        $parms = $this->parms;
        $res = checkParms($fields,$parms);
        if ($res) {
            return message($res,[],500);
        }
        if ($res['password'] != $res['re_password']) {
            return message('新密码和确认密码不一样',[],500);
        }

        $res = User::where('id',$parms['id'])->update(['password' => bcrypt($parms['password'])]);

        if ($res) {
            return message('修改成功',[],200);
        }
        else{
            return message('修改失败',[],500);
        }

    }

    public function getById(){
        //根据id获取
        $id = $this->parms['id'] != ''?$this->parms['id']:0;
        if (!$id) {
            return message('缺少id',[],404);
        }
        $data = User::leftJoin('role_users','role_users.user_id','users.id')
                    ->where('users.id',$id)
                    ->first(['users.id','role_id','phone','name']);
        return message('成功',$data,200);
    }

    public function update(){

        $parms = $this->parms;
        if (isset($parms['entry'])) {
            unset($parms['entry']);
        }
        $role['role_id'] = $parms['role_id'];

        unset($parms['role_id']);

        $res = User::where('id',$parms['id'])->update($parms);
        $res2 = RoleUser::where('user_id',$parms['id'])->update($role);

        if ($res && $res2) {
            return message('修改成功',[], 200);
        }
        else{
            return message('无修改',[], 200);
        }

        
    }
}
