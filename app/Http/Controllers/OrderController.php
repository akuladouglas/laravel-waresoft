<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Lineitems;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    
    function getOrders() {
      $data["orders"] = Order::orderby("id","desc")->paginate(15);
      
      return view("order/home", $data);
    }
    
    function syncOrders() {
      
      $get_url = "https://f79e3def682b671af1591e83c38ce094:c46734f74bad05ed2a7d9a621ce9cf7b@beautyclickke.myshopify.com/admin/orders.json?status=any";
      
      $get_url_timestamp = "https://f79e3def682b671af1591e83c38ce094:c46734f74bad05ed2a7d9a621ce9cf7b@beautyclickke.myshopify.com/admin/orders.json?since_id=496237740090";
      
      $contents = file_get_contents($get_url_timestamp);
      
      /*maneuvres*/
//      $results = json_decode($contents);
//      echo "<pre>";
//      print_r($results->orders[0]);
//      echo "</pre>";
//      exit();
      /*end maneuvres*/
      
      
      
      $shopify_orders = json_decode($contents);
      
      foreach ($shopify_orders->orders as $key => $shopify_order) {
        $order = new Order();
        $order->id = $shopify_order->id;
        $order->email = $shopify_order->email;
        if($shopify_order->closed_at){
         $order->closed_at = date("Y-m-d h:m:s", strtotime($shopify_order->closed_at));
        }
        $order->shopify_created_at = date("Y-m-d h:m:s", strtotime($shopify_order->created_at));
        $order->shopify_updated_at = date("Y-m-d h:m:s", strtotime($shopify_order->updated_at));
        $order->number = $shopify_order->number;
        $order->note = $shopify_order->note;
        $order->token = $shopify_order->token;
        $order->gateway = $shopify_order->gateway;
        $order->test = $shopify_order->test;
        $order->total_price = $shopify_order->total_price;
        $order->subtotal_price = $shopify_order->subtotal_price;
        $order->total_weight = $shopify_order->total_weight;
        $order->total_tax = $shopify_order->total_tax;
        $order->taxes_included = $shopify_order->taxes_included;
        $order->currency = $shopify_order->currency;
        $order->financial_status = $shopify_order->financial_status;
        $order->confirmed = $shopify_order->confirmed;
        $order->total_discounts = $shopify_order->total_discounts;
        $order->total_line_items_price = $shopify_order->total_line_items_price;
        $order->cart_token = $shopify_order->cart_token;
        $order->buyer_accepts_marketing = $shopify_order->buyer_accepts_marketing;
        $order->name = $shopify_order->name;
        $order->referring_site = $shopify_order->referring_site;
        $order->landing_site = $shopify_order->landing_site;
        $order->cancelled_at = $shopify_order->cancelled_at;
        $order->cancel_reason = $shopify_order->cancel_reason;
        $order->total_price_usd = $shopify_order->total_price_usd;
        $order->checkout_token = $shopify_order->checkout_token;
        $order->reference = $shopify_order->reference;
        $order->user_id = $shopify_order->user_id;
        $order->location_id = $shopify_order->location_id;
        $order->source_identifier = $shopify_order->source_identifier;
        $order->source_url = $shopify_order->source_url;
        $order->processed_at = $shopify_order->processed_at;
        $order->device_id = $shopify_order->device_id;
        $order->phone = $shopify_order->phone;
        $order->customer_locale = $shopify_order->customer_locale;
        $order->app_id = $shopify_order->app_id;
        $order->browser_ip = $shopify_order->browser_ip;
        $order->landing_site_ref = $shopify_order->landing_site_ref;
        $order->processing_method = $shopify_order->processing_method;
        $order->checkout_id = $shopify_order->checkout_id;
        $order->source_name = $shopify_order->source_name;
        $order->tags = $shopify_order->tags;
        $order->contact_email = $shopify_order->contact_email;
        $order->order_status_url = $shopify_order->order_status_url;
        $order_id = $shopify_order->id;
        $ordersline_items = $shopify_order->line_items;
        
        $order->save();
        
        //save line item
        if($ordersline_items){
          
          foreach ($ordersline_items as $key => $order_line_item) {
              $line_item = new Lineitems();
              $line_item->id = $order_line_item->id;
              $line_item->order_id = $order_id;
              $line_item->variant_id = $order_line_item->variant_id;
              $line_item->title = $order_line_item->title;
              $line_item->quantity = $order_line_item->quantity;
              $line_item->price = $order_line_item->price;
              $line_item->sku = $order_line_item->sku;
              $line_item->variant_title = $order_line_item->variant_title;
              $line_item->vendor = $order_line_item->vendor;
              $line_item->fulfillment_service = $order_line_item->fulfillment_service;
              $line_item->product_id = $order_line_item->product_id;
              $line_item->requires_shipping = $order_line_item->requires_shipping;
              $line_item->taxable = $order_line_item->taxable;
              $line_item->gift_card = $order_line_item->gift_card;
              $line_item->name = $order_line_item->name;
              $line_item->variant_inventory_management = $order_line_item->variant_inventory_management;
              $line_item->properties = "";
              $line_item->product_exists = $order_line_item->product_exists;
              $line_item->fulfillable_quantity = $order_line_item->fulfillable_quantity;
              $line_item->grams = $order_line_item->grams;
              $line_item->total_discount = $order_line_item->total_discount;
              $line_item->fulfillment_status = $order_line_item->fulfillment_status;
              $line_item->discount_allocations = "";
              $line_item->admin_graphql_api_id = $order_line_item->admin_graphql_api_id;
              $line_item->tax_lines = "";
            
              $line_item->save();
              
          }
          
        }
        
//        exit();
        
      }
      
      
      
    }
    
    
}
