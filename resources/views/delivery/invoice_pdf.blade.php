@extends("layouts.pdf_template")
@section('content')
<div class="row">
  <div class="col-lg-12">

    <div class="row">
      
      <div class="col-lg-5 pull-left" style="padding-left: 0px; padding-right: 0px;">
        <img width="250px" src="{{ asset('images/print_logo.png') }}"> 
      </div>
          
      <div class="col-lg-5 pull-right" style="text-align: right; float: right; padding-left: 0px; padding-right: 0px;">
        <small> {{ date("d/m/y") }} </small> <br>
        <small> Invoice for #{{ $order->number }}  </small>
      </div>
      
    </div>
    
    <table>
      <tbody>        
        <tr>
          <th> Website: www.beautyclick.co.ke </th>
        </tr>
        <tr>
          <td> Mitsumi Business Park, along Mutithi Road, Westlands </td>
        </tr>
        <tr>
          <td> Nairobi - Kenya </td>
        </tr>        
      </tbody>
    </table>
    
    <hr>
    
    <p class="pdf_title"> Item Details </p>
    
    <table class="table table-bordered table-sm">
      
      <tr>
        <th> Item </th>
        <th> Sku </th>
        <th> Quantity </th>
        <th> Price </th>
      </tr>
      
      @foreach($orderItems as $orderItem)
      <tr>
        <td> {{ $orderItem->name }} </td>
        <td> {{ $orderItem->sku }}  </td>
        <td> {{ $orderItem->quantity }} </td>
        <td> {{ $orderItem->price }} </td>
      </tr>
      @endforeach
      
    </table>
    
    <p class="pdf_title"> Payment Details </p>
    
    <table class="table table-bordered table-sm"> 
      
      <tr>
        <th> Payment Status </th>
        <th style="text-transform: uppercase;"> {{ $order->financial_status }} </th>
      </tr>
      
      <tr>
        <th> Sub total price </th>
        <td> {{ $order->subtotal_price }} </td>
      </tr>            
      
      <tr>
        <th> Shipping </th>
        <td> 
          {{ number_format( ($order->total_price-$order->subtotal_price), 2) }}
        </td>
      </tr>
      
      <tr>
        <th> Total Price </th>
        <td> {{ $order->total_price }} </td>
      </tr>
      
      <tr>
        <th> Total Tax </th>
        <td> {{ $order->total_tax }} </td>
      </tr>
      
      <tr>
        <th> Total Paid </th>
        <td> 
          {{ number_format($order->total_paid, 2) }} 
        </td>
      </tr>
      
      <tr>
        <th> Outstanding Amount </th>
        <td> 
          {{ number_format( ($order->total_price - $order->total_paid),2) }} 
        </td>
      </tr>
      
      <tr>
        <th> Payment Instruction </th>
        <td> M-PESA Paybill Number 638620 Account Number {{ $order->number }} </td>
      </tr>
      
    </table>
    
    @if($order->note)
    <p class="pdf_title"> Note </p>
    
    <table class="table table-bordered table-sm"> 
    
      <tr>
        <td colspan="100"> 
          <p> {{ $order->note }} </p>
        </td>
      </tr>
      
    </table>
    @endif
    <p> </p>
    
    <p class="pdf_title"> Shipping Details </p>
    
    <table class="table table-bordered table-sm"> 
    
      <tr>
        <td colspan="100"> 
          Customer Name : <b> {{ $order->customer_firstname." ".$order->customer_lastname }} </b> <br>
          Mobile Phone :  <b> {{ $order->customer_phone }} </b> <br>
        </td>
      </tr>
      
    </table>
    
    <p> If you have any questions, please contact us on <u> 0700552456 </u> </p>
    
  </div>
  
</div>
@endsection