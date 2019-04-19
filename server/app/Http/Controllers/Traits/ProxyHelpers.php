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
                return json_decode($response->getBody()->getContents(), true);
            }

        } catch (RequestException $exception) {
            return response()->json(returnMessage('Incorrect user name or password',401),$this->failureStatus);
            //throw new UnauthorizedHttpException('','Incorrect user name or password');
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
                return json_decode($respond->getBody()->getContents(), true);
            }

        } catch (RequestException $exception) {
            return response()->json(returnMessage('Request failure server error',401),$this->failureStatus);
        }

    }
}