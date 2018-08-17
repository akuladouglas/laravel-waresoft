<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Lineitems;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Mail;

class CyfeDashboardController extends Controller
{
    public $start_date;
    
    public $end_date;
    
    public $today;
    
    public $tags = ["faith","milly","barbara","doreen","walter","sharon","lydia","mahadia"];
    
    public $online_tags = ["milly","doreen","walter","sharon","lydia","mahadia"];
    
    public $offline_tags = ["faith","barbara"];
    
    public $cancelled_tags = ["COOD","NR","DD","DTU","RUD","PLO","IPLO","SO","CNLI"];
    
    public $cancelled_reason_tags = [
          "COOD" => "Change of order details",
          "NR"   => "No Response",
          "DD"   => "Delayed delivery",
          "DTU"  => "Delivery timelines unfeasible",
          "RUD"  => "Reject Upon delivery",
          "PLO"  => "Payment long overdue",
          "IPLO" => "In store pick up long overdue",
          "SO"   => "Stock Out",
          "CNLI" => "Client no longer interested"
         ];
    
    public $fullfillment_status = [
      null,"fulfilled","partial","shipped","unshipped"
    ];
    
    public $financial_status = [
      null, "authorized", "pending","paid","partially_paid","refunded","voided","partially_refunded","unpaid"
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->start_date = Carbon::parse("2018-08-01");
        $this->end_date = Carbon::parse("2018-08-31");
        $this->today = Carbon::now();
    }
    
    public function test()
    {
        $data = "Sales Staff, Revenue(Kes), Sales
              Barbara,100132,213
              Milly,120350,102
              Doreen,103420,54
              Faith,105413,21
              Walter,100200,1";
      
        echo $data;
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function fullfillmentRate()
    {
        $all_orders = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->count();
      
        $fullfilled_orders = Order::where("fulfillment_status", "fulfilled")
                                  ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                                  ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                                  ->count();
        
        $paid_fullfilled_orders = Order::where("fulfillment_status", "fulfilled")
                                  ->where("financial_status", "paid")
                                  ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                                  ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                                  ->count();
        
          
        $cood_orders = Order::where("tags", "like", "%COOD%")
                                  ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                                  ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                                  ->count();
        
        $cancelled_orders = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                                  ->where("cancelled_at","!=",null)
                                  ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                                  ->count();
        
        $cood_non_cancelled = Order::where("tags", "like", "%COOD%")
                                  ->where("cancelled_at",null)
                                  ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                                  ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                                  ->count();
        
        $fullfillment_rate = round((($paid_fullfilled_orders / ($all_orders - $cood_non_cancelled))*100), 2);
      
        $aggregate_all_orders = (($all_orders));
        
        $data = "All Orders, Cancelled, CooD, CooD Not Cancelled, Paid Fullfilled Orders, Fullfillment Rate (%)
               $aggregate_all_orders, $cancelled_orders, $cood_orders, $cood_non_cancelled, $paid_fullfilled_orders,$fullfillment_rate
               ";
      
        echo $data;
    }
    
    
    public function paidSalesAmount()
    {
        $paid_sales_count = Order::where("financial_status", "paid")
                                 ->where("cancelled_at", null)
                                 ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                                 ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                                 ->count();
      
        $paid_sales_amount = Order::where("financial_status", "paid")
                                  ->where("cancelled_at", null)
                                  ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                                  ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                                  ->sum("total_price");
        
        $paid_sales_amount_tax = Order::where("financial_status", "paid")
                                  ->where("cancelled_at", null)
                                  ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                                  ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                                  ->sum("total_tax");
      
        $ex_vat_total = ($paid_sales_amount - $paid_sales_amount_tax);
      
        $data = "As At, Number of Orders, Total Sales Inc VAT, Total Sales Ex VAT
                 {$this->today->format("d/m/y")}, $paid_sales_count, $paid_sales_amount ,$ex_vat_total
               ";
        
        echo $data;
        
    }
    
    public function averageBasketExVat()
    {
        $orders_total = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("cancelled_at", null)
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->sum("total_price");
        
        $total_tax = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                                ->where("cancelled_at", null)
                                ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                                ->sum("total_tax");
      
        $orders_count = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                                ->where("cancelled_at", null)
                                ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                                ->count();
      
        $basket_size = round(($orders_total / $orders_count), 2);
        $ex_vat_total = ($orders_total - $total_tax);
        
        $data = "As At, Total Sales ex VAT, Number of Orders, Average Basket size
          {$this->today->format("d/m/y")},$ex_vat_total, $orders_count, $basket_size   
           ";
      
        echo $data;
    }
    
    public function deliveredOrders()
    {
        $order_count = Order::where("fulfillment_status", "fulfilled")
                           ->where("cancelled_at", null)
                           ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->count();
      
        $order_total = Order::where("fulfillment_status", "fulfilled")
                            ->where("cancelled_at", null)
                            ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                            ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                            ->sum("total_price");
      
        $order_total_tax = Order::where("fulfillment_status", "fulfilled")
                            ->where("cancelled_at", null)
                            ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                            ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                            ->sum("total_tax");
        
        $order_total = round($order_total, 2);
        
        $order_total_tax = round($order_total_tax, 2);
        
        $total_ex_vat = round(($order_total - $order_total_tax),2);
        
        $data = "As At,Number of orders, Total Inc VAT, Order Ex Vat Total
               {$this->today->format("d/m/y")},$order_count, $order_total, $total_ex_vat
             ";
      
        echo $data;
    }
    
    public function revenueDeliveredOrdersExVat()
    {
        $order_count = Order::where("fulfillment_status", "fulfilled")
                           ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->count();
      
        $order_total = Order::where("fulfillment_status", "fulfilled")
                           ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->sum("total_price");
        
        $data = "Order Count, Order Total
              $order_count, $order_total
             ";
      
        echo $data;
    }
    
    public function offlineSales()
    {
        foreach ($this->offline_tags as $key => $tag) {
          
            $order_count[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("tags", "like", "%$tag%")
                             ->where("cancelled_at", null)
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->count();

            $order_total[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("tags", "like", "%$tag%")
                             ->where("cancelled_at", null)
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->sum("total_price");
            
            $order_total_tax[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("tags", "like", "%$tag%")
                             ->where("cancelled_at", null)
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->sum("total_tax");
            
        }
        
        $data = "As At, Number of orders, Total Inc Vat, Total ex Vat"."<br>";
        
        $order_total_summation = (array_sum($order_total));
        $order_total_tax_summation = (array_sum($order_total_tax));
        $order_count_summation = (array_sum($order_count));
        
        $ex_vat_total = ($order_total_summation - $order_total_tax_summation);
        
        $data .= "{$this->today->format("d/m/y")},$order_count_summation, $order_total_summation, $ex_vat_total"."<br>";
        
        echo $data;
        
    }
    
    public function onlineSales()
    {      
        foreach ($this->online_tags as $key => $tag) {
          
            $order_count[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("tags", "like", "%$tag%")
                             ->where("cancelled_at", null)
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->count();

            $order_total[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("tags", "like", "%$tag%")
                             ->where("cancelled_at", null)
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->sum("total_price");
            
            $order_total_tax[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("tags", "like", "%$tag%")
                             ->where("cancelled_at", null)
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->sum("total_tax");
            
        }
        
        $data = "As At,Number of orders, Total, Total ex Vat"."<br>";
        
        $order_total_summation = (array_sum($order_total));
        $order_total_tax_summation = (array_sum($order_total_tax));
        $order_count_summation = (array_sum($order_count));
        
        $ex_vat_total = ($order_total_summation - $order_total_tax_summation);
        
        $data .= "{$this->today->format("d/m/y")},$order_count_summation, $order_total_summation, $ex_vat_total"."<br>";
        
        echo $data;
        
    }
    
    public function untaggedSales()
    {      
        //all numbers
        
        $all_order_count = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                               ->where("cancelled_at", null)
                               ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                               ->count();

        $all_order_total = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                         ->where("cancelled_at", null)
                         ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                         ->sum("total_price");

        $all_order_total_tax = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                         ->where("cancelled_at", null)
                         ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                         ->sum("total_tax");
        
        foreach ($this->online_tags as $key => $tag) {
          
            $online_order_count[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("tags", "like", "%$tag%")
                             ->where("cancelled_at", null)
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->count();

            $online_order_total[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("tags", "like", "%$tag%")
                             ->where("cancelled_at", null)
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->sum("total_price");
            
            $online_order_total_tax[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("tags", "like", "%$tag%")
                             ->where("cancelled_at", null)
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->sum("total_tax");
            
        }
        
        foreach ($this->offline_tags as $key => $tag) {
          
            $offline_order_count[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("tags", "like", "%$tag%")
                             ->where("cancelled_at", null)
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->count();

            $offline_order_total[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("tags", "like", "%$tag%")
                             ->where("cancelled_at", null)
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->sum("total_price");
            
            $offline_order_total_tax[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("tags", "like", "%$tag%")
                             ->where("cancelled_at", null)
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->sum("total_tax");
            
        }
        
        $data = "As At,Number of orders, Total, Total ex Vat"."<br>";
        
        $offline_order_total_summation = (array_sum($offline_order_total));
        $offline_order_total_tax_summation = (array_sum($offline_order_total_tax));
        $offline_order_count_summation = (array_sum($offline_order_count));
        
        $online_order_total_summation = (array_sum($online_order_total));
        $online_order_total_tax_summation = (array_sum($online_order_total_tax));
        $online_order_count_summation = (array_sum($online_order_count));
        
        $order_total_summation = $all_order_total - ($offline_order_total_summation + $online_order_total_summation);
        $order_total_tax_summation = $all_order_total_tax - ($offline_order_total_tax_summation + $online_order_total_tax_summation);
        $order_count_summation = $all_order_count - ($offline_order_count_summation + $online_order_count_summation);
        
        $ex_vat_total = ($order_total_summation - $order_total_tax_summation);
        
        $data .= "{$this->today->format("d/m/y")},$order_count_summation, $order_total_summation, $ex_vat_total"."<br>";
        
        echo $data;
        
    }
    
    public function pendingOrders()
    {
      
        $order_count = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->where("financial_status","pending")
                           ->where("cancelled_at", null)
                           ->count();
      
        $order_total = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->where("financial_status","pending")
                           ->where("cancelled_at", null)
                           ->sum("total_price");
        
        $tax = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->where("financial_status","pending")
                           ->where("cancelled_at", null)
                           ->sum("total_tax");
        
        $ex_vat_order_total = round(($order_total - $tax),2);
        
        $data = "As At, Number of Orders, Total Inc VAT, Total Ex VAT
              {$this->today->format("d/m/y")}, $order_count, $order_total, $ex_vat_order_total
             ";
        
        echo $data;
        
    }
    
    public function pendingDeliveries()
    {
        $order_count = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->where("cancelled_at", null)
                           ->count();
      
        $order_total = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->where("cancelled_at", null)
                           ->sum("total_price");
      
        $data = "As At, Number of Orders, Total Inc VAT
                 {$this->today->format("d/m/y")}, $order_count, $order_total";
                 
        echo $data;
        
    }
    
    public function salesExVatPerStaff()
    {
      
        $all_order_count = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->where("fulfillment_status", "fulfilled")
                           ->where("financial_status", "paid")
                           ->where("cancelled_at", null)
                           ->count();
      
        $all_order_total = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                       ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                       ->where("fulfillment_status", "fulfilled")
                       ->where("financial_status", "paid")
                       ->where("cancelled_at", null)
                       ->sum("total_price");

        $all_order_total_tax = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                        ->where("fulfillment_status", "fulfilled")
                        ->where("financial_status", "paid")
                        ->where("cancelled_at", null)
                        ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                        ->sum("total_tax");
        
        $all_order_total_ex_vat = ($all_order_total - $all_order_total_tax);
        
        foreach ($this->tags as $tag) {
          
            $order_count[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->where("fulfillment_status", "fulfilled")
                           ->where("financial_status", "paid")
                           ->where("tags", "like", "%$tag%")
                           ->where("cancelled_at", null)
                           ->count();
      
            $order_total[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->where("fulfillment_status", "fulfilled")
                           ->where("financial_status", "paid")
                           ->where("tags", "like", "%$tag%")
                           ->where("cancelled_at", null)
                           ->sum("total_price");
        
            $order_total_tax[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                            ->where("tags", "like", "%$tag%")
                            ->where("fulfillment_status", "fulfilled")
                            ->where("financial_status", "paid")
                            ->where("cancelled_at", null)
                            ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                            ->sum("total_tax");
            
        }
      
        $datax = "As At,Staff, Number of Orders, Total ex VAT"."<br>";
      
        foreach ($this->tags as $key => $tag) {
            $ex_vat_amount[$tag] = round(($order_total[$tag] - $order_total_tax[$tag]),2);
            $data[$tag]["name"] = ucfirst($tag);
            $data[$tag]["order_count"] = $order_count[$tag];
            $data[$tag]["total_ex_vat"] = $ex_vat_amount[$tag];
        }
        
        usort($data, function($a, $b){
          return $a["total_ex_vat"] < $b["total_ex_vat"];
        });
        
        $combined_orders = 0;
        $combined_sales = 0;
        
        foreach ($data as $key => $data_item) {
          $combined_orders += $data_item["order_count"];
          $combined_sales += $data_item["total_ex_vat"];
          $datax .= $this->today->format("d/m/y").",".$data_item["name"].",".$data_item["order_count"].",".$data_item["total_ex_vat"]."<br>";
        }
        
        $untagged_order_count = ($all_order_count - $combined_orders);
        $untagged_order_total = ($all_order_total_ex_vat - $combined_sales);
        
        $datax .= $this->today->format("d/m/y").", Untagged, $untagged_order_count, $untagged_order_total ";
        
        $datax .= $this->today->format("d/m/y").", Total (All Staff), $all_order_count, $all_order_total_ex_vat ";
        
        echo $datax;
        
    }
    
    public function pendingDeliveriesExVatPerStaff()
    {
      
        foreach ($this->tags as $tag) {
          
            $order_count[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->where("tags", "like", "%$tag%")
                           ->where("cancelled_at", null)
                           ->where("financial_status","pending")
                           ->count();
      
            $order_total[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->where("tags", "like", "%$tag%")
                           ->where("cancelled_at", null)
                           ->where("financial_status","pending")
                           ->sum("total_price");
        
            $order_total_tax[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                              ->where("tags", "like", "%$tag%")
                              ->where("cancelled_at", null)
                              ->where("financial_status","pending")
                              ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                              ->sum("total_tax");
            
        }
        
        $datax = "As At, Staff, Number of Orders, Total ex VAT"."<br>";
      
        foreach ($this->tags as $key => $tag) {
            $ex_vat_amount[$tag] = round(($order_total[$tag] - $order_total_tax[$tag]),2);
            $data[$tag]["name"] = ucfirst($tag);
            $data[$tag]["order_count"] = $order_count[$tag];
            $data[$tag]["total_ex_vat"] = $ex_vat_amount[$tag];
        }
        
        usort($data, function($a, $b){
          return $a["total_ex_vat"] < $b["total_ex_vat"];
        });
        
        $combined_orders = 0;
        $combined_sales = 0;
        
        foreach ($data as $key => $data_item) {
          $combined_orders += $data_item["order_count"];
          $combined_sales += $data_item["total_ex_vat"];
          $datax .= $this->today->format("d/m/y").",".$data_item["name"].",".$data_item["order_count"].",".$data_item["total_ex_vat"]."<br>";
        }
        
        $datax .= $this->today->format("d/m/y").", Total (All Staff), $combined_orders, $combined_sales ";
        
        echo $datax;
        
    }
    
    public function cancelledOrders()
    {   
      
        foreach ($this->cancelled_tags as $tag) {
            
            $order_count[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->where("tags", "like", "%$tag%")
                           ->count();
      
            $order_total[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->where("tags", "like", "%$tag%")
                           ->sum("total_price");
        
            $order_total_tax[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                              ->where("tags", "like", "%$tag%")
                              ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                              ->sum("total_tax");
            
        }
      
        $data = " Cancelled Reason, As At, Number of Orders, Total ex VAT"."<br>";
        
        foreach ($this->cancelled_tags as $key => $tag) {
            $reason = $this->cancelled_reason_tags[$tag];
            $ex_vat_amount = round(($order_total[$tag] - $order_total_tax[$tag]),2);
            $data .= "$reason, {$this->today->format("d/m/y")}, $order_count[$tag], $ex_vat_amount"."<br>";
        }
      
        echo $data;
    }
    
    public function numberOfOrdersToday()
    {
        $order_count = Order::where("shopify_created_at", "like", Carbon::now()->format("Y-m-d")."%")->count();
        $order_total = Order::where("shopify_created_at", "like", Carbon::now()->format("Y-m-d")."%")->sum("total_price");
        $order_count_paid = Order::where("financial_status","paid")->where("shopify_created_at", "like", Carbon::now()->format("Y-m-d")."%")->count();
        $paid_order_total = Order::where("financial_status","paid")->where("shopify_created_at", "like", Carbon::now()->format("Y-m-d")."%")->sum("total_price");
        $paid_tax = Order::where("financial_status","paid")->where("shopify_created_at", "like", Carbon::now()->format("Y-m-d")."%")->sum("total_tax");
        $discounts = Order::where("shopify_created_at", "like", Carbon::now()->format("Y-m-d")."%")->sum("total_discounts");
          
        $ex_vat_order_total = round(($paid_order_total - $paid_tax),2);
        
        $data = "All Orders, Gross Amount, Paid Orders,  Paid Total Inc Vat, Paid Total ex Vat
              $order_count, $order_total, $order_count_paid, $paid_order_total, $ex_vat_order_total 
             ";
        
        echo $data;
    }
    
    public function salesTodayExVat()
    {
        $order_count = Order::where("shopify_created_at", "like", Carbon::now()->format("Y-m-d")."%")->count();
        $order_total = Order::where("shopify_created_at", "like", Carbon::now()->format("Y-m-d")."%")->sum("total_price");
        $order_total_tax = Order::where("shopify_created_at", "like", Carbon::now()->format("Y-m-d")."%")->sum("total_tax");
        $total_ex_vat = ($order_total - $order_total_tax);
      
        $data = "As At, Number of Orders, Total ex Vat
              {$this->today->format("d/m/y")}, $order_count, $total_ex_vat ";
      
        echo $data;
        
    }
    
    public function dailyTransactionBreakdown()
    {
        $date_range = $this->generateDateRange($this->start_date, $this->end_date);
        
        foreach ($date_range as $key => $date) {
          $order_count[$date] = Order::where("shopify_created_at", "like", Carbon::parse($date)->format("Y-m-d")."%")
                                       ->where("cancelled_at", null)
                                       ->count();
        
          $order_total[$date] = Order::where("shopify_created_at", "like", Carbon::parse($date)->format("Y-m-d")."%")
                                        ->where("cancelled_at", null)
                                        ->sum("total_price");
          
          $order_total_tax[$date] = Order::where("shopify_created_at", "like", Carbon::parse($date)->format("Y-m-d")."%")
                                        ->where("cancelled_at", null)
                                        ->sum("total_tax");
        }
        
        $data = "Date, Number of Orders, Total Inc VAT, Total Ex VAT"."<br>";
        
        foreach ($date_range as $key => $date) {
          $ex_vat_total[$date] = round(($order_total[$date] - $order_total_tax[$date]),2);
          $data .= "$date, $order_count[$date], $order_total[$date], $ex_vat_total[$date]"."<br>";
        }
        
        echo $data;
    }
    
    public function onelineSalesDailyTransactionBreakdown()
    {
        $date_range = $this->generateDateRange($this->start_date, $this->end_date);
        
        foreach ($date_range as $key => $date) {
          
          foreach ($this->online_tags as $tag) {
            
            $order_count[$date][$tag] = Order::where("shopify_created_at", "like", Carbon::parse($date)->format("Y-m-d")."%")
                                         ->where("tags", "like", "%$tag%")
                                         ->where("cancelled_at", null)
                                         ->count();
            
            $order_total[$date][$tag] = Order::where("shopify_created_at", "like", Carbon::parse($date)->format("Y-m-d")."%")
                                          ->where("tags", "like", "%$tag%")
                                          ->where("cancelled_at", null)
                                          ->sum("total_price");
            
            $order_total_tax[$date][$tag] = Order::where("shopify_created_at", "like", Carbon::parse($date)->format("Y-m-d")."%")
                                            ->where("tags", "like", "%$tag%")
                                            ->where("cancelled_at", null)
                                            ->sum("total_tax");
            
          }
          
        }
        
        foreach ($date_range as $key => $date) {          
          $aggregate_order_count[$date] = array_sum($order_count[$date]);
          $aggregate_order_total[$date] = array_sum($order_total[$date]);
          $aggregate_order_total_tax[$date] = array_sum($order_total_tax[$date]);          
        }
        
        $data = "Date, Number of Orders, Total Inc VAT, Total Ex VAT"."<br>";
        
        foreach ($date_range as $key => $date) {
          $ex_vat_total[$date] = round(($aggregate_order_total[$date] - $aggregate_order_total_tax[$date]),2);
          $data .= "$date, $aggregate_order_count[$date], $aggregate_order_total[$date], $ex_vat_total[$date]"."<br>";
        }
        
        echo $data;
    }
    
    
    private function generateDateRange(Carbon $start_date, Carbon $end_date, $minimal = false)
    {
        $dates = [];
      
        if ($minimal) {
            for ($date = $start_date; $date->lte($end_date); $date->addDay()) {
                $dates[] = $date->format("d");
            }
        } else {
            for ($date = $start_date; $date->lte($end_date); $date->addDay()) {
                $dates[] = $date->format("Y-m-d");
            }
        }
        return $dates;
    }
    
    public function breakdownByVendor() {
      
       $products = Lineitems::join("orders","orders.id","=","line_items.order_id")
                            ->select("line_items.vendor", DB::raw('sum(line_items.quantity) as total'), DB::raw('sum(line_items.price*line_items.quantity) as item_price'))
                            ->groupBy("line_items.vendor")
                            ->where("orders.shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                            ->where("orders.shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                            ->orderBy("total", "desc")                            
                            ->get();       
      
      $data = "Vendor, As At, Number of Items, Total Item Sales"."<br>";
      
      foreach ($products as $key => $product) {
        $data .= "$product->vendor, {$this->today->format("d/m/y")}, $product->total, $product->item_price"."<br>";
      }
      
      echo $data;
      
    }
    
    public function dailyBreakdownByVendor() {
      
       $products = Lineitems::join("orders","orders.id","=","line_items.order_id")
                            ->select("line_items.vendor", DB::raw('sum(line_items.quantity) as total'), DB::raw('sum(line_items.price*line_items.quantity) as item_price'))
                            ->groupBy("line_items.vendor")
                            ->where("orders.shopify_created_at", "like", $this->today->format("Y-m-d")."%")
                            ->orderBy("total", "desc")                            
                            ->get();       
      
      $data = "Vendor, As At, Number of Items, Total Item Sales"."<br>";
      
      foreach ($products as $key => $product) {
        $data .= "$product->vendor, {$this->today->format("d/m/y")}, $product->total, $product->item_price"."<br>";
      }
      
      echo $data;
      
    }
    
    public function breakdownByProduct() {
      
      $products = Lineitems::join("orders","orders.id","=","line_items.order_id")
                            ->select("line_items.title", DB::raw('count(*) as total'), DB::raw('sum(line_items.price*line_items.quantity) as item_price'))
                            ->groupBy("line_items.title")
                            ->where("orders.shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                            ->where("orders.shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                            ->orderBy("total", "desc")
                            ->limit(30)
                            ->get();
      
      $data = "Product, As At, Number of Products, Total Sales"."<br>";
      
      foreach ($products as $key => $product) {
        $data .= " $product->title, {$this->today->format("d/m/y")}, $product->total, $product->item_price"."<br>";
      }
      
      echo $data;
      
    }
    
    public function dailyBreakdownByProduct() {
      
      $products = Lineitems::join("orders","orders.id","=","line_items.order_id")
                            ->select("line_items.title", DB::raw('count(*) as total'), DB::raw('sum(line_items.price*line_items.quantity) as item_price'))
                            ->groupBy("line_items.title")
                            ->where("orders.shopify_created_at", "like", $this->today->format("Y-m-d")."%")
                            ->orderBy("total", "desc")
                            ->limit(30)
                            ->get();
      
      $data = "Product, As At, Number of Products, Total Sales"."<br>";
      
      foreach ($products as $key => $product) {
        $data .= " $product->title, {$this->today->format("d/m/y")}, $product->total, $product->item_price"."<br>";
      }
      
      echo $data;
      
    }
    
    public function breakdownBySku() {
      
      $products = Lineitems::join("orders","orders.id","=","line_items.order_id")
                            ->select("line_items.sku", DB::raw('count(*) as total'), DB::raw('sum(line_items.price*line_items.quantity) as item_price'))
                            ->groupBy("line_items.sku")
                            ->where("orders.shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                            ->where("orders.shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                            ->orderBy("total", "desc")
                            ->limit(30)
                            ->get();
      
      $data = "SKU, As At, Number of Items, Total Item Sales"."<br>";
      
      foreach ($products as $key => $product) {
        $data .= "$product->sku, {$this->today->format("d/m/y")},  $product->total, $product->item_price"."<br>";
      }
      
      echo $data;
      
    }
    
    
    public function dailyBreakdownBySku() {
      
      $products = Lineitems::join("orders","orders.id","=","line_items.order_id")
                            ->select("line_items.sku", DB::raw('count(*) as total'), DB::raw('sum(line_items.price*line_items.quantity) as item_price'))
                            ->groupBy("line_items.sku")
                            ->where("orders.shopify_created_at", "like", $this->today->format("Y-m-d")."%")
                            ->orderBy("total", "desc")
                            ->limit(30)
                            ->get();
      
      $data = "SKU, As At, Number of Items, Total Sales"."<br>";
      
      foreach ($products as $key => $product) {
        $data .= "$product->sku, {$this->today->format("d/m/y")},  $product->total, $product->item_price"."<br>";
      }
      
      echo $data;
      
    }
    
    public function breakdownReturningVsNew() {
      
      
      $all_customer_orders = Order::select("customer_id")
                           ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->where("financial_status","paid")
                           ->groupBy("customer_id")
                           ->get();
      
      foreach ($all_customer_orders as $key => $customer) {
        $orders_made[$customer->customer_id] = Order::where("financial_status","paid")->where("customer_id",$customer->customer_id)->count();
      }
      
      $new_customer_array = [];
      $returning_customer_array = [];
      
      foreach ($orders_made as $customer_id => $order_made) {
        if($order_made == 1){
          array_push($new_customer_array, $customer_id);
        } else{
          array_push($returning_customer_array, $customer_id);
        }
      }
      
      $new_customers = count($new_customer_array);
      $returning_customers = count($returning_customer_array);
      $all_customers = count($all_customer_orders);
      
      $data = "As At, All Customers, New Customers, Returning Customers"."<br>";
      
      $data .= "{$this->today->format("d/m/y")} , $all_customers, $new_customers, $returning_customers"."<br>";
      
      echo $data;
      
    }
    
    function fullfillmentStatusBreakdown() {
        
        foreach ($this->fullfillment_status as $key => $status) {
          
            $order_count[$status] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("fulfillment_status", $status)
                             ->where("cancelled_at", null)
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->count();

            $order_total[$status] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("fulfillment_status", $status)
                             ->where("cancelled_at", null)
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->sum("total_price");
            
            $order_total_tax[$status] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("fulfillment_status", $status)
                             ->where("cancelled_at", null)
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->sum("total_tax");
            
        }
        
        $datax = "As At, Fulfillment, Number of Orders, Total ex VAT"."<br>";
      
        foreach ($this->fullfillment_status as $key => $status) {
          if(($order_count[$status]) > 0){
            $ex_vat_amount[$status] = round(($order_total[$status] - $order_total_tax[$status]),2);
            $data[$status]["name"] = ucfirst($status);
              if(empty($data[$status]["name"])){
                $data[$status]["name"] = "Null";
              }
            $data[$status]["order_count"] = $order_count[$status];
            $data[$status]["total_ex_vat"] = $ex_vat_amount[$status];
          }
        }
        
        usort($data, function($a, $b){
          return $a["total_ex_vat"] < $b["total_ex_vat"];
        });
        
        $combined_orders = 0;
        $combined_sales = 0;
        
        foreach ($data as $key => $data_item) {
          $combined_orders += $data_item["order_count"];
          $combined_sales += $data_item["total_ex_vat"];
          $datax .= $this->today->format("d/m/y").",".$data_item["name"].",".$data_item["order_count"].",".$data_item["total_ex_vat"]."<br>";
        }
        
        $datax .= $this->today->format("d/m/y").", Total Sales, $combined_orders, $combined_sales ";
        
        echo $datax;
        
    }
    
    function financialStatusBreakdown() {
      
        foreach ($this->financial_status as $key => $status) {
          
            $order_count[$status] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("financial_status", $status)
                             ->where("cancelled_at", null)
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->count();

            $order_total[$status] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("financial_status", $status)
                             ->where("cancelled_at", null)
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->sum("total_price");
            
            $order_total_tax[$status] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("financial_status", $status)
                             ->where("cancelled_at", null)
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->sum("total_tax");
            
        }
        
        $datax = "As At, Financial, Number of Orders, Total ex VAT"."<br>";
        
        foreach ($this->financial_status as $key => $status) {
          if(($order_count[$status]) > 0){
            $ex_vat_amount[$status] = round(($order_total[$status] - $order_total_tax[$status]),2);
            $data[$status]["name"] = ucfirst($status);
            if(empty($data[$status]["name"])){
              $data[$status]["name"] = "Null";
            }
            $data[$status]["order_count"] = $order_count[$status];
            $data[$status]["total_ex_vat"] = $ex_vat_amount[$status];
          }
        }
        
        usort($data, function($a, $b){
          return $a["total_ex_vat"] < $b["total_ex_vat"];
        });
        
        $combined_orders = 0;
        $combined_sales = 0;
        
        foreach ($data as $key => $data_item) {
          $combined_orders += $data_item["order_count"];
          $combined_sales += $data_item["total_ex_vat"];
          $datax .= $this->today->format("d/m/y").",".$data_item["name"].",".$data_item["order_count"].",".$data_item["total_ex_vat"]."<br>";
        }
        
        $datax .= $this->today->format("d/m/y").", All Sales, $combined_orders, $combined_sales ";
        
        echo $datax;
      
    }
    
    
    function getPaymentPost($postdata) {
      
      mail("akulad19@gmail.com", "Test", $postdata);
      
    }
    
    
}