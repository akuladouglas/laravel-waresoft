<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function test() {
      
      $data = [];
      
      return view("dashboard/test");
      
    }
    
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function fullfillmentRate()
    {
      $data = array();
      
      return view("dashboard/fulfillment", $data);
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
