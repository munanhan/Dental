<?php

namespace App\Http\Middleware;
use Illuminate\Http\JsonResponse;

use Closure;

class EnableCrossRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    const ILLUMINATE_RESPONSE = 'Illuminate\Http\Response';
    const SYMFONY_RESPONSE = 'Symfony\Component\HttpFoundation\Response';

    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $origin = $request->server('HTTP_ORIGIN') ? $request->server('HTTP_ORIGIN') : '';
        $allow_origin = config('config.allow_origin') != ''?config('config.allow_origin'):[];//获取允许跨域的列表
        

        if(mb_strtolower($request->getMethod())=='options')
        {
            $response->setStatusCode(204);
            $response->header('Access-Control-Max-Age',600);
        }


        if (in_array($origin, $allow_origin)) {
            
            $IlluminateResponse = self::ILLUMINATE_RESPONSE;
            $SymfonyResponse = self::SYMFONY_RESPONSE;

            $headers = [
                           'Access-Control-Allow-Origin' => $origin,
                           'Access-Control-Allow-Headers' => 'Origin, Content-Type, Cookie, X-CSRF-TOKEN, Accept, Authorization, X-XSRF-TOKEN',
                           'Access-Control-Expose-Headers' => 'Authorization, authenticated',
                           'Access-Control-Allow-Methods' => 'GET, POST, PATCH, PUT, OPTIONS, DELETE',
                           'Access-Control-Allow-Credentials' => 'true'
                       ];

            switch ($response) {
                // 普通的http请求
                case ($response instanceof $IlluminateResponse) :
                    foreach ($headers as $key => $value) {
                        $response->header($key, $value);
                    }
                    break;
                // laravel-excel
                case ($response instanceof $SymfonyResponse):
                    foreach ($headers as $key => $value) {
                        $response->headers->set($key, $value);
                    }
                    break;
            }
            //设置跨域
            // $response->header('Access-Control-Allow-Origin', $origin);
            // $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Cookie, X-CSRF-TOKEN, Accept, Authorization, X-XSRF-TOKEN');
            // $response->header('Access-Control-Expose-Headers', 'Authorization, authenticated');
            // $response->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, OPTIONS, DELETE');
            // $response->header('Access-Control-Allow-Credentials', 'true');
        }



        return $response;
    }
}
