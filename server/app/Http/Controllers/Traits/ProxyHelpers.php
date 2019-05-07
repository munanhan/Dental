<?php

namespace App\Http\Controllers\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

trait ProxyHelpers
{
    /***
     * 获取访问令牌
     * @param string $guard
     * @return mixed
     */
    public function authenticate($guard=null)
    {
        try {

            $client = new Client();

            $url = request()->root() . '/oauth/token';

            $params = array_merge(config('passport.proxy'), [
                'username' => request('username'),
                'password' => request('password'),
                'provider' => $guard,
            ]);
            $response = $client->post($url, ['form_params' => $params]);

            if($response->getStatusCode() ===200){
                return response()->json(json_decode($response->getBody()->getContents(), true),'200');
            }

        } catch (RequestException $exception) {
            return response()->json('Incorrect user name or password',401);

        }

    }


    /***
     * 刷新令牌
     * @return mixed
     */
    public function getRefreshToken()
    {
        $client = new Client();

        try {
            $url = request()->root() . '/oauth/token';

            $params = array_merge(config('passport.refresh'), [
                'refresh_token' => request('refresh_token'),
            ]);

            $respond = $client->post($url, ['form_params' => $params]);

            if ($respond->getStatusCode() ===200 ) {
                return message('Login successful','200', json_decode($respond->getBody()->getContents(), true));
            }

        } catch (RequestException $exception) {
            return message('Request failure server error',401);
        }

    }
}