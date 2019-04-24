<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Podcast;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

class SendMobile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $podcast;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Podcast $podcast)
    {
        $this->podcast = $podcast;

    }


    public function handle()
    {

        AlibabaCloud::accessKeyClient(config('dysms.access_key_id'), 'accessKeySecret')
            ->regionId('cn-hangzhou')// replace regionId as you need
            ->asDefaultClient();

        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->options([
                    'query' => [
                        'RegionId' => 'cn-hangzhou',
                        'PhoneNumbers' => '13451728874',
                        'SignName' => '12123',
                        'TemplateCode' => '234444',
                        //'TemplateParam' => '2222',
                        //'SmsUpExtendCode' => '11',
                        //'OutId' => '3333',
                    ],
                ])
                ->request();

            print_r($result->toArray());

        } catch (ClientException $exception) {
            print_r($exception->getErrorMessage());
        } catch (ServerException $exception) {
            print_r($exception->getErrorMessage());
        }
    }
}
