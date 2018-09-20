@extends("layouts.main_template")

@section('content')

<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">

      @include('includes.notifications')

      <div class="header">
        <h2> Deliveries List  </h2>
      </div>

      <div class="body">
        <div class="table-responsive">
          <table class="table table-hover table-bordered dashboard-task-infos">
            <thead>
              <tr>
                <th>Date Made </th>
                <th>Customer </th>
                <th>Order </th>
                <th>Phone </th>
                <th>Total Price </th>
                <th>Financial Status </th>
                <th>Edit </th>
              </tr>
            </thead>
            <tbody>
              @foreach($deliveries as $order)
              <tr>
                <td> {{ date("y/m/d", strtotime($order->shopify_created_at)) }} </td>
                <td> {{ $order->customer_firstname }} {{ $order->customer_lastname }} </td>
                <td> <a href="{{url("order/view/{$order->id}")}}"> {{ $order->name }} </a> </td>
                <td> {{ $order->customer_phone }} </td>
                <td> {{ $order->total_price }} </td>
                <td> {{ $order->financial_status }} </td>
                <td> 
                 <a href="{{url("delivery/update/{$order->id}")}}" class="btn btn-xs btn-primary"> Edit Delivery </a> 
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
