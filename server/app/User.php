<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements MustVerifyEmail
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
            'password'
        ];

        /**
         * The attributes that should be cast to native types.
         *
         * @var array
         */
        protected $casts = [
            'email_verified_at' => 'datetime',
        ];

        /***
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function phone()
        {
            return $this->hasOne('App\Phone');
        }

        public function clinic()
        {
            return $this->belongsTo('App\Clinic');
        }

        /***
         * Multifield validation
         * @param $username
         * @return mixed
         */
        public function findForPassport($username)
        {
            return $this->orWhere('email',$username)->orWhere('phone',$username)->first();
        }

        /***
         * Reset password validation rules
         * @param $password
         * @return bool
         */
        public function validateForPassportPasswordGrant($password)
        {
            if(Hash::check($password,$this->password)){
                return true;
            }
            return false;
        }
}
