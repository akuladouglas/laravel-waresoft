@extends("layouts.main_template_datatable")

@section('content')

<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">

      @include('includes.notifications')
      
      <div class="header">

        <div class="col-lg-6">
          <h2> Customers List </h2>
        </div>

        <div class="col-lg-6">
          <a href="{{url("customer/refresh")}}" class="btn btn-primary pull-right"> Refresh Customer List </a>
        </div>
        <div class="clearfix"></div>

      </div>

      <div class="body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover dataTable js-exportable">

            <thead>
              <tr>
                <th>Customer</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Register At </th>
              </tr>
            </thead>
            <tbody>
              @foreach($customers as $customer)
              <tr>
                <td> {{ $customer->first_name." ".$customer->last_name }} </td>
                <td> {{ $customer->phone }} </td>
                <td> {{ $customer->email }} </td>
                <td> {{ date("Y/m/d h:m", strtotime($customer->created_at)) }}</td>
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