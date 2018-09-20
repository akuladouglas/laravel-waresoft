@extends("layouts.main_template_datatable")

@section('content')
<!-- Widgets -->
<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">

      @include('includes.notifications')

      <div class="header">

        <div class="col-lg-6">
          <h2> Orders List </h2>
        </div>

        <div class="col-lg-6">
          <a href="{{url("order/refresh")}}" class="btn btn-primary pull-right"> Refresh Orders List </a>
        </div>
        <div class="clearfix"></div>

      </div>

      <div class="body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover dataTable js-exportable">
            <thead>
              <tr>
                <th>Date Made</th>
                <th>Customer</th>
                <th>Order</th>
                <th>Price</th>
                <th>Fin. status </th>
                <th>Tags </th>
                <th>Note</th>
                <th>Send Pay Info</th>
                <th>Push STK</th>
                <th>Queue for <br> Delivery </th>
              </tr>
            </thead>
            <tbody>
              @foreach($orders as $order)
              
              <tr>
                <td> {{ date("y/m/d", strtotime($order->shopify_created_at)) }} </td>
                <td> {{ $order->customer_firstname }} {{ $order->customer_lastname }} </td>
                <td> <a href="{{url("order/view/{$order->id}")}}"> {{ $order->name }} </a> </td>
                <td> {{ number_format($order->total_price) }}</td>
                <td> {{ $order->financial_status }}</td>
                <td> {{ $order->tags }} </td>
                <td> {{ $order->note }}</td>
                <td> 
                  @if($order->financial_status != "paid" && $order->customer_phone)
                    <a onclick="return confirm('You are about to send Payment Information. Proceed ?')" href="{{url("payment/process-send-pay-info/{$order->id}")}}" class="btn btn-xs btn-primary"> Send Info </a>
                  @endif
                </td>
                <td> 
                  @if($order->financial_status != "paid" && $order->customer_phone)
                    <a onclick="return confirm('You are about to send an STK Push. Proceed ?')" href="{{url("payment/process-stk-push/{$order->id}")}}" class="btn btn-xs btn-success"> Push </a>
                  @endif
                </td>
                <td>  
                  @if(!$order->scheduled_delivery)
                    <a href="{{url("delivery/create/{$order->id}")}}" class="btn btn-xs btn-default"> For Delivery </a> 
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>

        </div>
      </div>

    </div>

  </div>
  <!-- #END# Task Info -->

</div>
@endsection