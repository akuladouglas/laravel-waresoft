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
                <th>Phone</th>
                <th>Total Price</th>
                <th>Financial Status </th>
                <th>Tags </th>
                <th></th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($orders as $order)
              <tr>
                <td> {{ date("Y/m/d", strtotime($order->shopify_created_at)) }} </td>
                <td> {{ $order->customer_firstname }} {{ $order->customer_lastname }} </td>
                <td> {{ $order->name }}</td>
                <td> {{ $order->customer_phone }} </td>
                <td> {{ $order->total_price }}</td>
                <td> {{ $order->financial_status }}</td>
                <td> {{ $order->tags }} </td>
                <td> 
                  @if($order->financial_status != "paid" && $order->customer_phone)
                  <a onclick="return confirm('You are about to send Payment Information. Proceed ?')" href="{{url("payment/process-send-pay-info/{$order->id}")}}" class="btn btn-xs btn-primary"> Send Pay <br> Info </a>
                  @endif
                </td>
                <td> 
                  @if($order->financial_status != "paid" && $order->customer_phone)
                  <a onclick="return confirm('You are about to send an STK Push. Proceed ?')" href="{{url("payment/process-stk-push/{$order->id}")}}" class="btn btn-xs btn-success"> Push STK </a>
                  @endif
                </td>
                <td>    
                  <a href="{{url("order/view/{$order->id}")}}" class="btn btn-xs btn-default">View More</a> 
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