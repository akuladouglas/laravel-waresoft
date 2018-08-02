<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CyfeDashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    
    public function test() {
      
      $data = "Sales Rep, Revenue($), Sales
              Jane Doe,100132,213
              Crystal Smith,52035,102
              Jack Carter,10342,54
              Mona Junior,5413,21
              Homer Simpson,100,1";
      
      echo $data;
      
    }
    
    function convertToCsv($array) {
      
      $csv = $array;
      
      dd($csv);
      
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function fullfillmentRate()
    {
      
      $data = "Sales Rep, Revenue($), Sales
              Jane Doe,100132,213
              Crystal Smith,52035,102
              Jack Carter,10342,54
              Mona Junior,5413,21
              Homer Simpson,100,1";
      
      echo $data;
      
//      return $this->convertToCsv($data);
    }
    
    
    public function paidSalesAmount()
    {
      $data = array();
      
      return view("dashboard/paidsalesamount", $data);
    }
    
    public function averageBasketExVat() {
      $data = array();
      
      return view("dashboard/avebasket", $data);
    }
    
    public function deliveredOrders() {
      $data = array();
      
      return view("dashboard/avebasket", $data);
    }
    
    public function revenueDeliveredOrdersExVat() {
      $data = array();
      
      return view("dashboard/deliveredordersrevenue", $data);
    }
    
    public function offlineSales() {
      $data = array();
      
      return view("dashboard/offlinesales", $data);
    }
    
    public function onlineSales() {
      $data = array();
      
      return view("dashboard/onlinesales", $data);
    }
    
    public function pendingOrders() {
      $data = array();
      
      return view("dashboard/pendingorders", $data);
    }
    
    public function pendingDeliveries() {
      $data = array();
      
      return view("dashboard/pendingdeliveries", $data);
    }
    
    public function salesExVatPerStaff() {
      $data = array();
      
      return view("dashboard/salesexvatperstaff", $data);
    }
    
    public function numberOfOrdersToday() {
      $data = array();
      
      return view("dashboard/orderstoday", $data);
    }
    
    public function salesTodayExVat() {
      $data = array();
      
      return view("dashboard/salestodayexvat", $data);
    }
    
    
}
