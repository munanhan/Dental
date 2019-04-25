<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use APP\User;
use App\Http\Controllers\Traits\SendSmsHelpers;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

class UserController extends Controller
{
    //use SendSmsHelpers;

    public function index()
    {
        return User::all();
    }

    public function show(User $user)
    {
        return $user;
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());

        return response()->json($user, 201);
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());

        return response()->json($user, 200);
    }

    public function delete(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }

    public function getMessage()
    {
        $this->setMessage();
        return Redis::get('phone');
    }

    public function setMessage()
    {
       return Redis::set('phone','13451728874');
    }

    public function getHashPassword()
    {
        return Hash::make('11111111');
    }

    public function getConfig()
    {
        $configArray= config('dysms');
        foreach ($configArray as $key=>$value)
        {
            echo $key .'=>'.$value;
            echo "<br>";
        }
    }

    public function sendMessage()
    {
        AlibabaCloud::accessKeyClient('LTAI3NfY6JVzdFI7', 'uyAiiBCMMBAyDmkjo59TZOXhrhHNHP')
            ->regionId('cn-hangzhou')
            ->asGlobalClient();

        try {
            $result = AlibabaCloud::rpcRequest()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->options([
                    'query' => [
                        'RegionId' => 'cn-hangzhou',
                        'TemplateParam' => '{"code":"222222"}',
                        'TemplateCode' => 'SMS_137865176',
                        'SignName' => '魔方科技',
                        'PhoneNumbers' => '13451728874',
                    ],
                ])
                ->request();
            print_r($result->toArray());
        } catch (ClientException $e) {
            echo $e->getErrorMessage() . PHP_EOL;
        } catch (ServerException $e) {
            echo $e->getErrorMessage() . PHP_EOL;
        }
    }
}
