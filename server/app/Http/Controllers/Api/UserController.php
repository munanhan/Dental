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
use phpseclib\Crypt\Hash;
use App\Http\Controllers\Api\BaseController;


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

    


}
