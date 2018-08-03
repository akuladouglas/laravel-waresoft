<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class CyfeDashboardController extends Controller
{
    public $start_date;
    
    public $end_date;
    
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
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->start_date = Carbon::parse("2018-08-01");
        $this->end_date = Carbon::parse("2018-08-31");
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
        
        $fullfillment_rate = round((($paid_fullfilled_orders / $all_orders)*100), 3);
      
        $data = "All Orders, Paid Fullfilled Orders, Fullfillment Rate (%)
               $all_orders,$paid_fullfilled_orders,$fullfillment_rate
               ";
      
        echo $data;
    }
    
    
    public function paidSalesAmount()
    {
        $paid_sales_count = Order::where("financial_status", "paid")
                                 ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                                 ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                                 ->count();
      
        $paid_sales_amount = Order::where("financial_status", "paid")
                                  ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                                  ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                                  ->sum("total_price");
        
        $paid_sales_amount_tax = Order::where("financial_status", "paid")
                                  ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                                  ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                                  ->sum("total_tax");
      
        $ex_vat_total = ($paid_sales_amount - $paid_sales_amount_tax);
      
        $data = "Number of Orders, Total Sales Ex VAT, Total Sales Ex VAT
               $paid_sales_count, $paid_sales_amount ,$ex_vat_total
               ";
        
        echo $data;
        
    }
    
    public function averageBasketExVat()
    {
        $orders_total = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->sum("total_price");
        
        $total_tax = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                                ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                                ->sum("total_tax");
      
        $orders_count = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                                ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                                ->count();
      
        $basket_size = round(($orders_total / $orders_count), 2);
        $ex_vat_total = ($orders_total - $total_tax);
        
        $data = "Total Sales ex VAT, Number of Orders, Average Basket size
               $ex_vat_total, $orders_count, $basket_size   
           ";
      
        echo $data;
    }
    
    public function deliveredOrders()
    {
        $order_count = Order::where("fulfillment_status", "fulfilled")
                           ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->count();
      
        $order_total = Order::where("fulfillment_status", "fulfilled")
                            ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                            ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                            ->sum("total_price");
      
        $order_total_tax = Order::where("fulfillment_status", "fulfilled")
                            ->where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                            ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                            ->sum("total_tax");
        
        $order_total = round($order_total, 2);
        
        $order_total_tax = round($order_total_tax, 2);
        
        $total_ex_vat = round(($order_total - $order_total_tax),2);
        
        $data = "Number of orders, Total Inc VAT, Vat, Order Ex Vat Total
              $order_count, $order_total, $order_total_tax, $total_ex_vat
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
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->count();

            $order_total[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("tags", "like", "%$tag%")
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->sum("total_price");
            
            $order_total_tax[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("tags", "like", "%$tag%")
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->sum("total_tax");
            
        }
        
        $data = "Number of orders, Total Inc Vat, Total ex Vat"."<br>";
        
        $order_total_summation = (array_sum($order_total));
        $order_total_tax_summation = (array_sum($order_total_tax));
        $order_count_summation = (array_sum($order_count));
        
        $ex_vat_total = ($order_total_summation - $order_total_tax_summation);
        
        $data .= "$order_count_summation, $order_total_summation, $ex_vat_total"."<br>";
        
        echo $data;
        
    }
    
    public function onlineSales()
    {      
        foreach ($this->online_tags as $key => $tag) {
          
            $order_count[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("tags", "like", "%$tag%")
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->count();

            $order_total[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("tags", "like", "%$tag%")
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->sum("total_price");
            
            $order_total_tax[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                             ->where("tags", "like", "%$tag%")
                             ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                             ->sum("total_tax");
            
        }
        
        $data = "Number of orders, Total, Total ex Vat"."<br>";
        
        $order_total_summation = (array_sum($order_total));
        $order_total_tax_summation = (array_sum($order_total_tax));
        $order_count_summation = (array_sum($order_count));
        
        $ex_vat_total = ($order_total_summation - $order_total_tax_summation);
        
        $data .= "$order_count_summation, $order_total_summation, $ex_vat_total"."<br>";
        
        echo $data;
        
    }
    
    public function pendingOrders()
    {
      
        $order_count = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->count();
      
        $order_total = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->sum("total_price");
        
        $tax = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->sum("total_tax");
        
        $ex_vat_order_total = round(($order_total - $tax),2);
        
        $data = "Number of Orders, Total Inc VAT, Total Ex VAT
              $order_count, $order_total, $ex_vat_order_total
             ";
        
        echo $data;
        
    }
    
    public function pendingDeliveries()
    {
        $order_count = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->count();
      
        $order_total = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->sum("total_price");
      
        $data = "Number of Orders, Total Inc VAT
                  $order_count, $order_total";
                 
        echo $data;
        
    }
    
    public function salesExVatPerStaff()
    {
        
        foreach ($this->tags as $tag) {
          
            $order_count[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->where("fulfillment_status", "fulfilled")
                           ->where("financial_status", "paid")
                           ->where("tags", "like", "%$tag%")
                           ->count();
      
            $order_total[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->where("fulfillment_status", "fulfilled")
                           ->where("financial_status", "paid")
                           ->where("tags", "like", "%$tag%")
                           ->sum("total_price");
        
            $order_total_tax[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                            ->where("tags", "like", "%$tag%")
                            ->where("fulfillment_status", "fulfilled")
                            ->where("financial_status", "paid")
                            ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                            ->sum("total_tax");
            
        }
      
        
        
        $data = "Staff, Number of Orders, Total ex VAT"."<br>";
      
        foreach ($this->tags as $key => $tag) {
            $ex_vat_amount[$tag] = round(($order_total[$tag] - $order_total_tax[$tag]),2);
            $data .= "$tag, $order_count[$tag], $ex_vat_amount[$tag]"."<br>";
        }
      
        echo $data;
        
    }
    
    public function pendingDeliveriesExVatPerStaff()
    {
      
        foreach ($this->tags as $tag) {
          
            $order_count[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->where("tags", "like", "%$tag%")
                           ->where("financial_status","pending")
                           ->count();
      
            $order_total[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                           ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                           ->where("tags", "like", "%$tag%")
                           ->where("financial_status","pending")
                           ->sum("total_price");
        
            $order_total_tax[$tag] = Order::where("shopify_created_at", ">=", $this->start_date->format("Y-m-d"))
                              ->where("tags", "like", "%$tag%")
                              ->where("financial_status","pending")
                              ->where("shopify_created_at", "<=", $this->end_date->endOfDay()->format("Y-m-d H:i"))
                              ->sum("total_tax");
            
        }
      
        $data = "Staff, Number of Orders, Total ex VAT"."<br>";
      
        foreach ($this->tags as $key => $tag) {
            $data .= "$tag, $order_count[$tag], $order_total[$tag]"."<br>";
        }
      
        echo $data;
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
      
        $data = "Cancelled Reason, Number of Orders, Total ex VAT"."<br>";
        
        foreach ($this->cancelled_tags as $key => $tag) {
            $reason = $this->cancelled_reason_tags[$tag];
            $ex_vat_amount = round(($order_total[$tag] - $order_total_tax[$tag]),2);
            $data .= "$reason, $order_count[$tag], $ex_vat_amount"."<br>";
        }
      
        echo $data;
    }
    
    public function numberOfOrdersToday()
    {
        $order_count = Order::where("shopify_created_at", "like", Carbon::now()->format("Y-m-d")."%")->count();
        $order_total = Order::where("shopify_created_at", "like", Carbon::now()->format("Y-m-d")."%")->sum("total_price");
        $tax = Order::where("shopify_created_at", "like", Carbon::now()->format("Y-m-d")."%")->sum("total_tax");
        $discounts = Order::where("shopify_created_at", "like", Carbon::now()->format("Y-m-d")."%")->sum("total_discounts");
          
        $ex_vat_order_total = round(($order_total - $tax),2);
        
        $data = "NUmber of Orders, Total Inc Vat, Total ex Vat
              $order_count, $order_total, $ex_vat_order_total 
             ";
        
        echo $data;
    }
    
    public function salesTodayExVat()
    {
        $order_count = Order::where("shopify_created_at", "like", Carbon::now()->format("Y-m-d")."%")->count();
        $order_total = Order::where("shopify_created_at", "like", Carbon::now()->format("Y-m-d")."%")->sum("total_price");
        $order_total_tax = Order::where("shopify_created_at", "like", Carbon::now()->format("Y-m-d")."%")->sum("total_tax");
        $total_ex_vat = ($order_total - $order_total_tax);
      
        $data = "Number of Orders, Total ex Vat
              $order_count, $total_ex_vat ";
      
        echo $data;
        
    }
    
    public function dailyTransactionBreakdown()
    {
        $date_range = $this->generateDateRange($this->start_date, $this->end_date);
        
        foreach ($date_range as $key => $date) {
          $order_count[$date] = Order::where("shopify_created_at", "like", Carbon::parse($date)->format("Y-m-d")."%")
                             ->count();
        
          $order_total[$date] = Order::where("shopify_created_at", "like", Carbon::parse($date)->format("Y-m-d")."%")
                             ->sum("total_price");
          
          $order_total_tax[$date] = Order::where("shopify_created_at", "like", Carbon::parse($date)->format("Y-m-d")."%")
                             ->sum("total_tax");
        }
        
        $data = "Date, Number of Orders, Total Inc VAT, Total Ex VAT"."<br>";
        
        foreach ($date_range as $key => $date) {
          $ex_vat_total[$date] = round(($order_total[$date]),2);
          $data .= "$date, $order_count[$date], $order_total[$date], $ex_vat_total[$date]"."<br>";
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
    
}