<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Kavenegar\Laravel\Facade;

trait SendSms
{

    public function kavenegar($mobile,$message)
    {
        try{
            $sender = env('KAVENEGAR_SENDER_NUMBER');
            $receptor = [$mobile];
            $result = Kavenegar::Send($sender,$receptor,$message);
            if($result)
            {
                // foreach($result as $r){
                //     echo "messageid = $r->messageid";
                //     echo "message = $r->message";
                //     echo "status = $r->status";
                //     echo "statustext = $r->statustext";
                //     echo "sender = $r->sender";
                //     echo "receptor = $r->receptor";
                //     echo "date = $r->date";
                //     echo "cost = $r->cost";
                // }    
                
                //Should Log sms result-- skip it for now

            }
        }
        catch(\Kavenegar\Exceptions\ApiException $e){
            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
            echo $e->errorMessage();
        }
        catch(\Kavenegar\Exceptions\HttpException $e){
            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
            echo $e->errorMessage();
        }
    }

    public function ghasedak($mobile,$message)
    {
        try
        {
            // $url = "https://api.ghasedak.me/v2/sms/send/simple";

            // $params = [];
            // $params['message'] = $message;
            // $params['receptor'] = $mobile;
            // $params['linenumber'] = env('GHASEDAK_SENDER_NUMBER');
            // $params['checkid'] = 1;

            // $client = new \GuzzleHttp\Client(['validation' => false]);
        }
        catch(ApiException $e){
     
            throw $e->errorMessage();
        }
        catch(HttpException $e){
     
            throw $e->errorMessage();
        }
    }

}
