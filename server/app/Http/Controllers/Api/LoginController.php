<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\ProxyHelpers;
use App\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class LoginController extends Controller
{
    use ProxyHelpers;

    protected $successStatus=200;
    protected $failureStatus=401;


    public function login()
    {
        $user=$this->getFirst($this->getUsername());

        if($user &&($user->status===0)){
            return message('Account disabled',403);
        }

        return $this->authenticate();
    }

    public function refreshToken()
    {
       return $this->getRefreshToken();
    }

    public function logout()
    {
        if (Auth::guard('api')->check()) {
            Auth::guard('api')->user()->token()->delete();
        }

        return response()->json(returnMessage('Log out successfully'),$this->successStatus);
    }

    protected function getUsername()
    {
        return request('username');
    }

    protected function getFirst($username)
    {
        return User::orWhere('email', $username)->orWhere('phone', $username)->first();
    }


}
