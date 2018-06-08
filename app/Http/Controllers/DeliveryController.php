<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    //
  
  function getDeliverys() {
    
      $data[] = '';
      
      return view("delivery/home", $data);
  }
  
}
