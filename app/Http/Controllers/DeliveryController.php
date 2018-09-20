<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\Rider;
use DB;
use Auth;
use PDF;

class DeliveryController extends Controller
{
    
    /**
     * Get list of deliveries
     * @return type
     */
  
    public function getDeliverys()
    {
        $data["deliveries"] = Delivery::join("orders","orders.id","deliverys.order_id")
          ->get();
        $data["riders"] = Rider::get();
        return view("delivery/home", $data);
    }
    
    /**
     * First step of order management
     */
    
    public function createDelivery($order_id, Request $request) {
      
      $delivery = new Delivery(); 
      $delivery->order_id = $order_id;
      $delivery->save();
      
      return redirect(url("delivery"));
    }
    
    /**
     * Second step of order management
     */
    
    public function downloadDeliveryNote(Request $request) {
       
      $delivery = Delivery::join("orders","orders.id","=","delivery.order_id") 
        ->where("orders.order_id", $request->order_id);
      //load pdf view of the same
      $pdf = PDF::loadview();
      
//      return pdf view of receipt
    }
    
    /**
     * Third step of order management
     */
    public function assignRider(Request $request) {
      
      $delivery = Delivery::where("order_id",$request->input("order_id"))->get()->first();
      $delivery->rider_id = $request->input("rider_id");
      $delivery->save();
      $request->session()->flash("success","Updated rider for delivery");
      return redirect(url("delivery"));
      
    }
    
    /**
     * Fourth step of order management
     */
    
    public function updateDelivered(Request $request) {
      
      $delivery = Delivery::find($request->input("delivery_id"));
      $delivery->delivered = 1;
      $delivery->save();
      
      return redirect();
    }
    
    /**
     * Fift step of order management
     * @param Request $request
     */
    
    public function updatePaymentMethodUsed(Request $request) {
      
      $delivery = Delivery::find($request->input("delivery_id"));
      $delivery->paymenth_method_id = $request->payment_method_id;
      $delivery->payment_method_updater_user_id = Auth::user()->id;
      $delivery->save();
      
      return redirect();
    }
    
    
    /**
     * Sixth step of order management
     */
    
    public function decrementDeliveredStock(Request $request) {
      
//      get full order details + delivery details
      $order = Order::join("deliveries");
//      gets sku in order
      $sku = $order->sku;
//      check sku stocks in warehouse
      $sql = "update stocks set quantity=quantity-1 where sku=$sku";
//      decrement stocks in warehouse
      DB::Raw($sql);
      
      return redirect();
    }
    
    /**
     * Update delivery
     */
    
    public function updateDelivery($order_id, Request $request) {
      
      $data["order_id"] = $order_id;
      if($request->all()){
        
       $delivery = Delivery::where("order_id",$order_id)->get()->first();
       $delivery->rider_id = 1;
       $delivery->save();
       
       return redirect(url("delivery"));
       
      }
      
      return view("delivery/update", $data);
    }
    
    
}
