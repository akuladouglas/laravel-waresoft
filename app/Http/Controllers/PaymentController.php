<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class PaymentController extends Controller
{
    
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
  
  public function processStkPush($order_id) {
    
    $order = Order::find($order_id);
    
    if($order){
      
      $phone_number = str_replace(" ", "", $order->customer_phone);
      $formatted_phone_number = "254".substr($phone_number, -9);
      $order_amount = $order->total_price;
      
      //do push
      
      //record push in stats
      
      //send sms notification either way
      
      //wait for results of callback and record
      
      return redirect("order");
    }
    return false;
    
  }
  
}
