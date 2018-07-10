<?php

namespace App\Http\Controllers;
use App\Models\Customer;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CustomerController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    
    function getCustomers() {
      $data["customers"] = Customer::orderby("id","desc")->paginate(15);
      
      return view("customer/home", $data);
    }
    
    function syncCustomers() {
      
      $get_url = "https://f79e3def682b671af1591e83c38ce094:c46734f74bad05ed2a7d9a621ce9cf7b@beautyclickke.myshopify.com/admin/customers.json?since_id=737853341753&limit=250"; //449367507001

//    $get_url_timestamp = "https://f79e3def682b671af1591e83c38ce094:c46734f74bad05ed2a7d9a621ce9cf7b@beautyclickke.myshopify.com/admin/orders.json?since_id=496237740090";
      
      $contents = file_get_contents($get_url);
      
      $results = json_decode($contents);
      
      echo "<pre>";
      print_r(count($results->customers));
      echo "</pre>";
      
      echo "<pre>";
//      print_r($results->customers);
      echo "</pre>";
//      exit();
      
      
      $shopify_customers = json_decode($contents);
      
      foreach ($shopify_customers->customers as $key => $shopify_customer) {
        
        $customer = new Customer;
        $customer->customerid = $shopify_customer->id;
        $customer->email = rtrim($shopify_customer->email);
        $customer->first_name = rtrim($shopify_customer->first_name);
        $customer->last_name = rtrim($shopify_customer->last_name);
        
        if(!empty($shopify_customer->default_address->phone)){
         $customer->phone = $shopify_customer->default_address->phone;
        }
        
        $customer->admin_graphql_api_id = $shopify_customer->admin_graphql_api_id;
        
        $customer->save();
        
      }
      
      
      
    }
    
    
}
