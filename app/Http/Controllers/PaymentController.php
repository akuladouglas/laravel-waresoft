<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
  
}
