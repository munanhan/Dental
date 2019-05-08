<?php

namespace App\Http\Controllers\Api;

use App\Model\Clinic;
use App\Model\Company;
use App\Model\Phone;
use Illuminate\Http\Request;
use App\Model\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Traits\SendSmsHelpers;
use App\Http\Controllers\Traits\SmsPolicy;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;



class RegisterController extends Controller
{

    use SendSmsHelpers ,SmsPolicy;

    public function index()
    {
        $phone=request('phone');

        if(isPhone($phone)===false){
            return message('The cell phone number is incorrect','',400);
        }

        $this->phoneNumbers=$phone;
        $this->templateParam=$this->makeCode($phone);

        if($this->send()===true){
            $this->createPhone($phone);
            return message('','',200);
        }

        return message('Server exception','',500);
    }

    public function register(Request $request)
    {
        $data=$request->all();
        //$flag=request('flag');
        $flag=1; //默认为诊所
        if($this->validator($data)->fails()){
            return message($this->validator($data)->errors(),'',400);
        }
        //创建用户认证的事件，并监听

        if($flag==0){
            $company=$this->createCompany($data);
            $data['company_id']=$company->id;
        }else{
            $clinic=$this->createClinic($data);
            $data['clinic_id']=$clinic->id;
        }

        event(new Registered($user = $this->createUser($data)));

        $user->roles()->attach(1);

        return  message('','',200);

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

    protected function createUser(array $data)
    {
        return User::create([
            'phone'=>$data['phone'],
            'email' => $data['email'],
            'name'=>$data['name'],
            'password' => Hash::make($data['password']),
            'clinic_id'=>$data['clinic_id'],
            'company_id'=>$data['company_id'],
        ]);
    }

    protected function createCompany(array $data)
    {
        return Company::create([
            'contact'=>$data['contact'],
            'name'=>$data['name'],
            'phone'=>$data['phone'],
        ]);
    }

    protected function createClinic(array $data)
    {
        return Clinic::create([
            'contact'=>$data['contact'],
            'name'=>$data['name'],
            'phone'=>$data['phone'],
        ]);
    }

    protected function createPhone($phone)
    {
        return Phone::create([
            'phone'=>$phone,
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
            return response()->json('',200);
        }
        return message('Verification failed','',400);
    }

}
