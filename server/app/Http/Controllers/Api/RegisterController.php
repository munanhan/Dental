<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Traits\SendSmsHelpers;
use App\Http\Controllers\Traits\SmsPolicy;
use Illuminate\Support\Facades\Validator;



class RegisterController extends Controller
{

    use SendSmsHelpers ,SmsPolicy;

    public function index()
    {
        $phone=request('phone');

        if(isPhone($phone)===false){
            return message('The cell phone number is incorrect',400);
        }

        $this->phoneNumbers=$phone;
        $this->templateParam=$this->makeCode($phone);

        if($this->send()===true){
            return message('SMS sent successfully',200);
        }

        return message('Server exception',500);
    }

    public function register(Request $request)
    {
        if($this->validator($request->all())->fails()){
            return returnMessage($this->validator($request->all())->errors(),400);
        }
        //创建用户认证的事件，并监听
        event(new Registered($user = $this->create($request->all())));

        return returnMessage('registered successfully',201);

    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'phone'=>['required','numeric','unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'name'=>['required','string'],
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

    protected function makeCode($phone)
    {
        $code=sixRandom();
        Redis::set('user:'.$phone,$code);
        Redis::setex('user:'.$phone,300,$code);
        return json_encode(['code'=>$code]);
    }

    public function verification()
    {
        $phone=request('phone');
        $code=request('code');
        if(Redis::get('user:'.$phone)==$code) {
            return message('verify successfully ',200);
        }
        return message('Verification failed',400);
    }

}
