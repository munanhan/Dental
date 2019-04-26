<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use APP\User;
use App\Http\Controllers\Traits\SendSmsHelpers;


class UserController extends Controller
{
    use SendSmsHelpers;

    public function index()
    {
        return User::all();
    }

    public function show(User $user)
    {
        return $user;
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());

        return response()->json($user, 201);
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());

        return response()->json($user, 200);
    }

    public function delete(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }

    public function getMessage()
    {
        $this->setMessage();
        return Redis::get('phone');
    }

    public function setMessage()
    {
       return Redis::set('phone','13451728874');
    }

    public function getHashPassword()
    {
        return Hash::make('11111111');
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
