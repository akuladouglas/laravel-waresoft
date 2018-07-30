<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RewardSms;

class QueuesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    
    public function sendSms($phonenumber, $message)
    {
        $url = 'https://isms.infosky.co.ke/sms2/api/v1/send-sms';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer ACCESS_TOKEN')); //setting custom header

        $curl_post_data = array(
          //Fill in the request parameters with valid values
          'acc_no' => "0145",
          'api_key' => "g8s4J8J6HYT8r5q8p1G5N3V9G9dAB9bu",
          'sender_id' => "Beautyclick",
          'message' => "$message",
          'msisdn' => [$phonenumber],
          'dlr_url' => ""
        );

        $data_string = json_encode($curl_post_data);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        $curl_response = curl_exec($curl);

        return true;
    }
    
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function rewardsSmsQueue()
    {
        $sms_queue = RewardSms::where("sent", 0)->get()->take(5);
        
        foreach ($sms_queue as $key => $queue) {
          
            $this->sendSms($queue->phone, $queue->text);
          
            $sms_obj = RewardSms::where("rewards_sms_id", $queue->rewards_sms_id)->get()->first();
            $sms_obj->sent = 1;
            $sms_obj->save();
        }
    }
}
