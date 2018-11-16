@extends("layouts.main_template_datatable")

@section('content')
<!-- Widgets -->
      
<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">

      <div class="header">
        <h2> Orders Detail
         <a href="{{url("order")}}" class="btn btn-default btn-xs pull-right"> Back to Orders </a>
        </h2>
      </div>

      <div class="body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover dataTable">
            <thead>
              <tr>
                <th> Item </th>
                <th> Value </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th> Id </th>
                <td> {{ $order->id }} </td>
              </tr>
              <tr>
                <th> Email </th>
                <td> {{ $order->email }} </td>
              </tr>
              <tr>
                <th> Created At </th>
                <td> {{ $order->shopify_created_at }} </td>
              </tr>
              <tr>
                <th> Updated At </th>
                <td> {{ $order->shopify_updated_at }} </td>
              </tr>
              <tr>
                <th> Number </th>
                <td> {{ $order->number }} </td>
              </tr>
              <tr>
                <th> Note </th>
                <td> {{ $order->note }} </td>
              </tr>
              
              <tr>
                <th> Gateway </th>
                <td> {{ $order->gateway }} </td>
              </tr>
              <tr>
                <th> Total Price </th>
                <td> {{ $order->total_price }} </td>
              </tr>
              <tr>
                <th> Sub Total Price </th>
                <td> {{ $order->subtotal_price }} </td>
              </tr>
              <tr>
                <th> Shipping </th>
                <td> {{ number_format( ($order->total_price-$order->subtotal_price), 2)  }} </td>
              </tr>
              <tr>
                <th> Total Tax </th>
                <td> {{ $order->total_tax }} </td>
              </tr>
              <tr>
                <th> Financial Status </th>
                <td> {{ $order->financial_status }} </td>
              </tr>
              <tr>
                <th> Confirmed </th>
                <td> {{ $order->confirmed ? "Yes" : "No" }} </td>
              </tr>
              <tr>
                <th> Total Discounts </th>
                <td> {{ $order->total_discounts }} </td>
              </tr>
              <tr>
                <th> Total Line items Price </th>
                <td> {{ $order->total_line_items_price }} </td>
              </tr>
              
              <tr>
                <th> User id </th>
                <td> {{ $order->user_id }} </td>
              </tr>
              
              <tr>
                <th> Processed At </th>
                <td> {{ $order->processed_at }} </td>
              </tr>
              
              <tr>
                <th> Processed Method </th>
                <td> {{ $order->manual }} </td>
              </tr>
              
              <tr>
                <th> Source Name </th>
                <td> {{ $order->source_name }} </td>
              </tr>
              
              <tr>
                <th> Fullfillment Status </th>
                <td> {{ $order->fulfillment_status }} </td>
              </tr>
              
              <tr>
                <th> Tags </th>
                <td> {{ $order->tags }} </td>
              </tr>
              
              <tr>
                <th> Order Status Url </th>
                <td> <a target="_blank" href="{{ $order->order_status_url }}">{{ $order->order_status_url }}</a> </td>
              </tr>
              
            </tbody>
          </table>
          
          
        </div>
      </div>



    </div>

  </div>
  <!-- #END# Task Info -->

</div>
@endsection