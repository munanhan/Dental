<?php

namespace App;

use App\Notifications\InvoicePaid;
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
            return $this->hasOne(Phone::class);
        }

        public function clinic()
        {
            return $this->belongsTo(Clinic::class);
        }

        public function roles()
        {
            return $this->belongsToMany(Role::class);
        }

        //获取关联中间表的创建时间字段
        public function Pivot()
        {
            $user=User::find(1);
            foreach ($user->roles as $role){
                return $role->pivot->role_id;
            }
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

        /***
         * 延迟十分钟通过队列发送支付成功通知
         */
        public function sendPaidNotification()
        {
            $when=now()->addMinutes(10);
            $this->notify((new InvoicePaid($this))->delay($when));
        }
}
