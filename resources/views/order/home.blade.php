@extends("layouts.main_template_datatable")

@section('content')
<!-- Widgets -->
<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">

      <div class="header">
        <h2> Orders List </h2>
      </div>

      <div class="body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover dataTable js-exportable">
            <thead>
              <tr>
                <th>#</th>
                <th>Total Price</th>
                <th>Total Price</th>
                <th>Total Discounts</th>
                <th>Tax</th>
                <th>Date Made</th>
                <th>Financial Status </th>
                <th>Tags </th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($orders as $order)
              <tr>
                <td> {{ $order->id }} </td>
                <td> {{ $order->total_price }} </td>
                <td> {{ $order->subtotal_price }}</td>
                <td> {{ $order->total_discounts }}</td>
                <td> {{ $order->total_tax }}</td>
                <td> {{ date("d/m/y", strtotime($order->shopify_created_at)) }} </td>
                <td> {{ $order->financial_status }}</td>
                <td> {{ $order->tags }} </td>
                <td> <a href="{{url("order/view/{$order->id}")}}" class="btn btn-xs btn-primary">View More</a> </td>
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