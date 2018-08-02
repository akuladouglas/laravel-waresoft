<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class CyfeDashboardController extends Controller
{
    public $start_date;
    
    public $end_date;
    
    public $tags = ["faith","milly","barbara","doreen","walter","sharon"];
    
    public $online_tags = ["milly","doreen","walter","sharon"];
    
    public $offline_tags = ["faith","barbara"];
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->start_date = Carbon::parse("2018-07-01");
        $this->end_date = Carbon::parse("2018-07-31");
    }
    
    public function test()
    {
        dd($this->start_date);
      
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
                           ->where("shopify_created_at", ">=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->count();
      
        $fullfilled_orders = Order::where("fulfillment_status", "fulfilled")
                                  ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                                  ->where("shopify_created_at", ">=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                                  ->count();
      
        $fullfillment_rate = round((($fullfilled_orders / $all_orders)*100), 3);
      
        $data = "All Orders, Fullfilled Orders, Fullfillment Rate (%)
               $all_orders,$fullfilled_orders,$fullfillment_rate
               ";
      
        echo $data;
    }
    
    
    public function paidSalesAmount()
    {
        $paid_sales_count = Order::where("financial_status", "paid")
                                 ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                                 ->where("shopify_created_at", ">=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                                 ->count();
      
        $paid_sales_amount = Order::where("financial_status", "paid")
                                  ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                                  ->where("shopify_created_at", ">=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                                  ->sum("total_price");
        $paid_sales_amount_tax = Order::where("financial_status", "paid")
                                  ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                                  ->where("shopify_created_at", ">=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                                  ->sum("total_tax");
      
        $ex_vat_total = ($paid_sales_amount - $paid_sales_amount_tax);
      
        $data = "Sales Number, Sales Amount
               $paid_sales_count, $ex_vat_total
               ";
      
        echo $data;
    }
    
    public function averageBasketExVat()
    {
        $orders_total = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("shopify_created_at", ">=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->sum("total_price");
        
        $total_tax = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                                ->where("shopify_created_at", ">=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                                ->sum("total_tax");
      
        $orders_count = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                                ->where("shopify_created_at", ">=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                                ->count();
      
        $basket_size = round(($orders_total / $orders_count), 2);
        $ex_vat_total = ($orders_total - $total_tax);
      
        $data = "Order Total, Order Count, Basket size
               $ex_vat_total, $orders_count, $basket_size   
           ";
      
        echo $data;
    }
    
    public function deliveredOrders()
    {
        $order_count = Order::where("fulfillment_status", "fulfilled")
                           ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", ">=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->count();
      
        $order_total = Order::where("fulfillment_status", "fulfilled")
                            ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                            ->where("shopify_created_at", ">=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                            ->sum("total_price");
      
        $order_total_tax = Order::where("fulfillment_status", "fulfilled")
                            ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                            ->where("shopify_created_at", ">=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                            ->sum("total_tax");
      
        $total_ex_vat = ($order_total - $order_total_tax);
      
        $data = "Order Count, Total, Vat, Order Ex Vat Total
              $order_count, $order_total, $order_total_tax, $total_ex_vat
             ";
      
        echo $data;
    }
    
    public function revenueDeliveredOrdersExVat()
    {
        $order_count = Order::where("fulfillment_status", "fulfilled")
                           ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", ">=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->count();
      
        $order_total = Order::where("fulfillment_status", "fulfilled")
                           ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", ">=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
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
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->count();

            $order_total[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("tags", "like", "%$tag%")
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->sum("total_price");

            $data = "Staff, Order Count, Order Total"."<br>";
            
        }
    
        foreach ($this->offline_tags as $key => $tag) {
            $data .= "$tag, $order_count[$tag], $order_total[$tag]"."<br>";
        }
      
        echo $data;
    }
    
    public function onlineSales()
    {      
        foreach ($this->online_tags as $key => $tag) {
          
            $order_count[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("tags", "like", "%$tag%")
                             ->where("shopify_created_at", ">=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->count();

            $order_total[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("tags", "like", "%$tag%")
                             ->where("shopify_created_at", ">=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->sum("total_price");
            
            $data = "Staff, Order Count, Order Total"."<br>";
            
        }
    
        foreach ($this->online_tags as $key => $tag) {
            $data .= "$tag, $order_count[$tag], $order_total[$tag]"."<br>";
        }
      
        echo $data;
    }
    
    public function pendingOrders()
    {
        $order_count = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", ">=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->count();
      
        $order_total = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", ">=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->sum("total_price");
      
        $data = "Order Count, Order Total
              $order_count, $order_total
             ";
      
        echo $data;
    }
    
    public function pendingDeliveries()
    {
        $order_count = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", ">=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->count();
      
        $order_total = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", ">=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->sum("total_price");
      
        $data = "Order Count, Order Total
              $order_count, $order_total
             ";
      
        echo $data;
    }
    
    public function salesExVatPerStaff()
    {
        foreach ($this->tags as $tag) {
            $order_count[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", ">=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->where("tags", "like", "%$tag%")
                           ->count();
      
            $order_total[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", ">=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->where("tags", "like", "%$tag%")
                           ->sum("total_price");
        
            $order_total_tax[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                              ->where("tags", "like", "%$tag%")
                              ->where("shopify_created_at", ">=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                              ->sum("total_tax");
        }
      
        $data = "Staff, Order Count, Order Total"."<br>";
      
        foreach ($this->tags as $key => $tag) {
            $data .= "$tag, $order_count[$tag], $order_total[$tag]"."<br>";
        }
      
        echo $data;
    }
    
    public function pendingDeliveriesExVatPerStaff()
    {
      
        foreach ($this->tags as $tag) {
          
            $order_count[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", ">=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->where("tags", "like", "%$tag%")
                           ->where("financial_status","pending")
                           ->count();
      
            $order_total[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", ">=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->where("tags", "like", "%$tag%")
                           ->where("financial_status","pending")
                           ->sum("total_price");
        
            $order_total_tax[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                              ->where("tags", "like", "%$tag%")
                              ->where("financial_status","pending")
                              ->where("shopify_created_at", ">=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                              ->sum("total_tax");
            
        }
      
        $data = "Staff, Order Count, Order Total"."<br>";
      
        foreach ($this->tags as $key => $tag) {
            $data .= "$tag, $order_count[$tag], $order_total[$tag]"."<br>";
        }
      
        echo $data;
    }
    
    public function numberOfOrdersToday()
    {
        $order_count = Order::where("shopify_created_at", "like", Carbon::now()->format("Y-m-d")."%")->count();
        $order_total = Order::where("shopify_created_at", "like", Carbon::now()->format("Y-m-d")."%")->sum("total_price");
      
        $data = "Order Count, Order Total
              $order_count, $order_total
             ";
      
        echo $data;
    }
    
    public function salesTodayExVat()
    {
        $order_count = Order::where("shopify_created_at", "like", Carbon::now()->format("Y-m-d")."%")->count();
        $order_total = Order::where("shopify_created_at", "like", Carbon::now()->format("Y-m-d")."%")->sum("total_price");
        $order_total_tax = Order::where("shopify_created_at", "like", Carbon::now()->format("Y-m-d")."%")->sum("total_tax");
        $total_ex_vat = ($order_total - $order_total_tax);
      
        $data = "Order Count, Order Total
              $order_count, $total_ex_vat
             ";
      
        echo $data;
    }
}
