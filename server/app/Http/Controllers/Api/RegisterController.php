<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;



class RegisterController extends Controller
{

    public function register(Request $request)
    {
        if($this->validator($request->all())->fails()){
            return response()->json(returnMessage($this->validator($request->all())->errors(),401), 401);
        }
        //创建用户认证的事件，并监听
        event(new Registered($user = $this->create($request->all())));

        return response()->json(returnMessage('registered successfully'), 200);

    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'phone'=>['required','numeric','unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'phone'=>$data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
