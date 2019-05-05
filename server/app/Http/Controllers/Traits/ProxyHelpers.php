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
        // try {

            $client = new Client();

            $url = request()->root() . '/oauth/token';

            $params = array_merge(config('passport.proxy'), [
                'username' => request('username'),
                'password' => request('password'),
                'provider' => $guard,
            ]);
/*******************************先屏蔽***********************************************************************/
            // $response = $client->post($url, ['form_params' => $params]);

        //     if($response->getStatusCode() ===200){
        //         return message('Login successful','200', json_decode($response->getBody()->getContents(), true));
        //     }

        // } catch (RequestException $exception) {
        //     return message('Incorrect user name or password',401);

        // }
/**********************************************************************************************************/
        $ch = curl_init();//初始化
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        $data = json_decode($data,1);//转化成数组输出
        dd($data);
        return message('Login successful','200', json_decode($data, true));

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