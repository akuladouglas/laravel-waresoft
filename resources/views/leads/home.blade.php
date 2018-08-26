@extends("layouts.main_template_datatable")

@section('content')
<!-- Widgets -->
<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    
    <div class="card">

      <div class="header">
        <div class="col-lg-6">
          <h2> Leads </h2>
        </div>
        <div class="col-lg-6">
          <a href="{{url("leads/add")}}" class="btn btn-primary pull-right"> Add New Lead </a>
        </div>
        <div class="clearfix"></div>
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
              <tr>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
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