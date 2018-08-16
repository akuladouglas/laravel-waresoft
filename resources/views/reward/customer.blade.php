@extends("layouts.main_template_datatable")

@section('content')
<!-- Widgets -->

<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">

      <div class="header">
        <h2> Rewards Customers List </h2>
      </div>

      <div class="body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover dataTable js-exportable">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Total Spent</th>
                <th>Total Orders</th>
                <th>Birth Date</th>
                <th>Created At</th>
                <th>Updated At</th>
              </tr>
            </thead>
            <tbody>
              @foreach($customers as $customer)
              <tr>
                <td> {{ $customer->firstName }}  {{ $customer->lastName }} </td>
                <td> {{ $customer->emailAddress }} </td>
                <td> {{ $customer->totalSpent }} </td>
                <td> {{ $customer->totalOrders }} </td>
                <td> {{ $customer->birthDate ? $customer->birthDate : "-" }} </td>
                <td> {{ date("Y/m/d", strtotime($customer->createdAt)) }} </td>
                <td> {{ date("Y/m/d", strtotime($customer->updatedAt)) }} </td>
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