<?php

namespace App\Http\Controllers\Traits;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

trait SendSmsHelpers
{

    /***
     * @var  number phone
     */
    protected  $phoneNumbers;

    /***
     * @var json {"code":""}
     */
    protected  $templateParam;

    public function send()
    {
        $this->client();

        if($this->sendMode() =='OK'){
           return true;
       }

        return false;
    }

    public function client()
    {
        return AlibabaCloud::accessKeyClient($this->getAccessKeyId(), $this->getAccessSecret())
            ->regionId($this->getRegionId())
            ->asGlobalClient();
    }

    public function sendMode()
    {
        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->options($this->getQuery())
                ->request();

            return $result->toArray()['Code'];

        } catch (ClientException $exception) {
            print_r($exception->getErrorMessage());
        } catch (ServerException $exception) {
            print_r($exception->getErrorMessage());
        }
    }

    public function getRegionId()
    {
        return config('dysms.region_id');
    }

    public function getAccessKeyId()
    {
        return config('dysms.access_key_id');
    }

    public function getAccessSecret()
    {
        return config('dysms.access_key_secret');
    }

    public function getSignName()
    {
        return config('dysms.sign_name');
    }

    public function getTemplateCode()
    {
        return config('dysms.template_code');
    }

    public function getQuery()
    {
        return [
            'query' => [
                'RegionId' =>$this->getRegionId(),
                'TemplateParam' => $this->templateParam,
                'TemplateCode' => $this->getTemplateCode(),
                'SignName' => $this->getSignName(),
                'PhoneNumbers' => $this->phoneNumbers,
            ]
        ];
    }
}