<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Stkstats;
use App\User;
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
  
  public function suregifts(Request $request)
  {
      $data[] = 0;
      
      if($request->has("voucher_code")){
        
        
        $request->flash("success", "voucher does not exist");
        return view("payment/suregifts", $data);
      }
      
      return view("payment/suregifts", $data);
  }
  
  
   /* custom codes added for beautyclick */

  
  public function getValidationUrl($country, $mode) {
    $_validationUrl = array(
      'KEN' => array('test' => "http://kenyastaging.oms-suregifts.com/api/voucherredemption", "live" => "http://kenya.oms-suregifts.com/api/voucherredemption"),
      'NGR' => array('test' => "http://sandbox.oms-suregifts.com/api/voucherredemption", "live" => "https://oms-suregifts.com/api/voucherredemption")
    );
    return $_validationUrl[$country][$mode == "1" ? "test" : "live"];
  }
  
  public function processSuregiftsCode($suregift_code = false) {

    $success = false;
    $amount_to_use = 0;
    $errors = array();

    if ($suregift_code) {

      $username = "beautyclick_api";
      $password = "@fl8tiket123#";
      $website_host = "https://beautyclick.co.ke";
      $mode = (int) 0;
      $country = "KEN";
      $auth = $username . ':' . $password;
      $validationUrl = $this->getValidationUrl($country, $mode);
      
      $ch = curl_init($validationUrl . '?vouchercode=' . $suregift_code);
      curl_setopt($ch, CURLOPT_POST, false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
      curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
      if ($username != '') {
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Authorization: Basic " . base64_encode($auth),
          )
        );
      }

      $resp = curl_exec($ch);
      $response_info = array();
      curl_close($ch);
      $response_info = json_decode($resp, true);
      
      dd($response_info);
      
      if (isset($response_info['AmountToUse']) && (float) $response_info['AmountToUse']) {
        $success = true;
        $amount_to_use = $response_info['AmountToUse'];
//        if (!Db::getInstance()->executeS('SELECT * FROM ' . _DB_PREFIX_ . 'cart_suregifts WHERE suregifts_card="' . $suregift_code . '"'))
//          Db::getInstance()->execute('INSERT INTO ' . _DB_PREFIX_ . 'cart_suregifts (id_cart_suregifts,id_cart,suregifts_card,suregifts_value) values("","' . (int) $this->context->cart->id . '","' . $suregift_code . '","' . (float) $response_info['AmountToUse'] . '")');
//        else
//          $errors[] = 'The SureGifts Voucher has already been used!';
      }
      else {
        $errors[] = 'The SureGifts Voucher is invalid or has already been used!';
      }
    }
    
    return array(
      'success' => $success,
      'amount_to_use' => $amount_to_use,
      'errors' => $errors
    );
  }
  
  public function redeemSuregiftsCode($suregift_code = false, $amount_to_use = 0) {
    
    $success = false;
    $errors = [];
    
    $post_parameters = array(
      "AmountToUse" => $amount_to_use,
      "VoucherCode" => $suregift_code,
      "WebsiteHost" => "https://beautyclick.co.ke"
    );
    
    $content = json_encode($post_parameters);
    
    if ($suregift_code) {
      
      $username = "beautyclick_api";
      $password = "@fl8tiket123#";
      $website_host = "https://beautyclick.co.ke";
      $mode = (int) 0;
      $country = "KEN";
      $auth = $username . ':' . $password;
      $validationUrl = $this->getValidationUrl($country, $mode);
      $ch = curl_init($validationUrl);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
      curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
      if ($username != '') {
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Authorization: Basic " . base64_encode($auth),
          "Content-type: application/json"
          )
        );
      }

      $resp = curl_exec($ch);
      $response_info = array();
      curl_close($ch);
      $response_info = json_decode($resp, true);
    }
    
    dd($response_info);
    
    return true;
    
  }
  
  public function mpesaPushStats()
  {
      $data["stats"] = Stkstats::join("users","users.id","stk_stats.user_id")->get();
      
      return view("payment/pushstats", $data);
  }
  
  public function processStkPush($order_id, Request $request) {
    
    $order = Order::find($order_id);
    
    if($order){
      
      $phone_number = str_replace(" ", "", $order->customer_phone);
      $formatted_phone_number = "254".substr($phone_number, -9);
      $order_amount = round($order->total_price);
      $account_number = str_replace("#", "", $order->name);
      
      //do push
      $payment_service = new PaymentService();
      $payment_service->sendSTK($formatted_phone_number, $order_amount, $account_number);
        
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
      
  
  public function processSendPayInfo($order_id, Request $request) {
    
    $order = Order::find($order_id);
    
    if($order){
      
      $phone_number = str_replace(" ", "", $order->customer_phone);
      $formatted_phone_number = "254".substr($phone_number, -9);
      $order_amount = round($order->total_price);
      $account_number = str_replace("#", "", $order->name);
      
      //send sms notification with payment info
      $message = "Hi $order->customer_firstname, To complete payment for your order. Please make payment of $order_amount to paybill 654221 and account number $account_number. Thank you.";
      $sms = new SmsService();
      $sms->sendNewSms($formatted_phone_number, $message);
      
      //wait for results of callback and record
      $request->session()->flash('success', "Payment Information to $order->customer_firstname has been sent");
      return redirect("order");
      
    }
//    return false;
    
  }
  
}
