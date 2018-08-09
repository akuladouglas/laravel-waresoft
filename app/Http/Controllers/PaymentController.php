<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Stkstats;
use App\Services\PaymentService;
use App\Services\SmsService;
use Auth;
use DB;


class PaymentController extends Controller
{
    
  public function __construct()
    {
        $this->middleware('auth');
    }
  
  public function paymentsList()
  {
      $data[] = 0;
      
      return view("payment/home", $data);
  }
  
  public function requestMpesa()
  {
      $data[] = 0;
      
      return view("payment/requestMpesa", $data);
  }
  
  public function suregifts()
  {
      $data[] = 0;
      
      return view("payment/suregifts", $data);
  }
  
  public function mpesaPushStats()
  {
      $data[] = 0;
      
      return view("payment/pushstats", $data);
  }
  
  public function processStkPush($order_id, Request $request) {
    
    $order = Order::find($order_id);
    
    if($order){
      
      $phone_number = str_replace(" ", "", $order->customer_phone);
      $formatted_phone_number = 254721869246;  //"254".substr($phone_number, -9);
      $order_amount = round($order->total_price);
      $account_number = str_replace("#", "", $order->name);
      
      //do push
//      $payment_service = new PaymentService();
//      $payment_service->sendSTK($formatted_phone_number, $order_amount, $account_number);
        
      //record push in stats
      $stk_stat = Stkstats::where("order_name", $account_number)->get()->first();
      
      if(!$stk_stat){
        $stk_stat = new Stkstats();
        $stk_stat->user_id = Auth::user()->id;
        $stk_stat->order_name = $account_number;
        $stk_stat->total_pushes = 1;
        $stk_stat->save();
      } else {
        DB::table('stk_stats')->where("stk_stats_id", $stk_stat->stk_stats_id)->increment('total_pushes');
      }
        
      //send sms notification either way
      $message = "Hi $order->customer_firstname, If you haven't completed payment for your order. Please make payment to paybill 654221 and account number $account_number. Thank you.";
      $sms = new SmsService();
      $sms->sendNewSms($formatted_phone_number, $message);
      
      //wait for results of callback and record
      $request->session()->flash('success', "Payment Push to $order->customer_firstname was successful!");
      return redirect("order");
    }
//    return false;
    
  }
  
}
