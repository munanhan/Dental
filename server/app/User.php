<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
        use HasApiTokens,Notifiable;

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'name', 'email', 'password','phone',
        ];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            'password', 'remember_token',
        ];

        /**
         * The attributes that should be cast to native types.
         *
         * @var array
         */
        protected $casts = [
            'email_verified_at' => 'datetime',
        ];

        //多字段验证，默认单字段Email
        public function findForPassport($username)
        {
            return $this->orWhere('email',$username)->orWhere('phone',$username)->first();
        }

        //重置密码验证规则
//        public function validateForPassportPasswordGrant($password)
//        {
//            if(Hash::check($password,$this->password)){
//                return true;
//            }
//            return false;
//        }
}
