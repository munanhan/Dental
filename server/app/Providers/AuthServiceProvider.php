<?php

namespace App\Providers;

use App\Policies\UserPolicy;
use App\User;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\RouteRegistrar;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class=>UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        //多用户多表验证
//        Passport::routes(function (RouteRegistrar $router){
//            $router->forAccessTokens();
//        },['prefix'=>'api/oauth','middleware'=>'passport']);

        //设置token有效期，默认永久
        Passport::tokensExpireIn(now()->addDays(30));

        Passport::refreshTokensExpireIn(now()->addDays(30));
    }
}
