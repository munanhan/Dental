<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use App\Model\User;
use App\Model\Role;
use App\Model\RoleUser;
use App\Http\Controllers\Traits\SendSmsHelpers;
use Illuminate\Support\Facades\Crypt;


class UserController extends Controller
{
    use SendSmsHelpers;

    public function index()
    {
        return message('',User::all(),200);
    }

    public function getCurrentUser()
    {
        return message('',Auth::user(),200);
    }

    public function show(User $user)
    {
        return message('',$user,200);
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());

        return message('',$user, 200);
    }

    public function update(Request $request, User $user)
    {
        $parms = $request->all();
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

    // public function delete(User $user)
    // {
    //     $user->delete();

    //     return message('',null, 200);
    // }

    public function getMessage()
    {
        $this->setMessage();
        return Redis::get('phone');
    }

    public function setMessage()
    {
       return Redis::set('phone','13451728874');
    }


    public function getConfig()
    {
        $configArray= config('dysms');
        foreach ($configArray as $key=>$value)
        {
            echo $key .'=>'.$value;
            echo "<br>";
        }
    }

    public function sendMessage()
    {
        $this->send();
    }

    public function subscribe()
    {
        Redis::psubscribe(['*'], function ($message, $channel) {
            echo $message;
        });

        Redis::psubscribe(['users.*'], function ($message, $channel) {
            echo $message;
        });
    }

    public function userList(Request $request){
        //员工列表
        $parms = getParms($request->input());
        $parms = $parms['parms'];//参数
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

    public function addUser(Request $request){
        //添加用户
        $fields = [ 'phone' => '电话',
                    'password' => '密码',
                    'name' => '姓名',
                    'role_id' => '角色'
                  ];//必填字段

        $parms = $request->input();
        $res = checkParms($fields,$parms);//验证字段信息

        if ($res) {
            //字段验证不通过
            return message($res,[],500);
        }

        $find = User::where('phone',$parms['phone'])->first();
        if ($find) {
            // return message('用户已存在',[],500);
        }
        $role['role_id'] = $parms['role_id'];
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

    public function updatePassword(Request $request){
        //修改密码
        $fields = [ 'password' => '新密码',
                    're_password' => '确认密码',
                    'id' => 'id'
                  ];
        $parms = $request->input();
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

    public function getById(Request $request){
        //根据id获取
        $id = $request->input('id') != ''?$request->input('id'):0;
        if (!$id) {
            return message('缺少id',[],404);
        }
        $data = User::leftJoin('role_users','role_users.user_id','users.id')
                    ->where('users.id',$id)
                    ->first(['users.id','role_id','phone','name']);
        return message('成功',$data,200);
    }


}
