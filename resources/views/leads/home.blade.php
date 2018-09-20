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
                <th>Date</th>
                <th>Staff Name</th>
                <th>Client Name</th>
                <th>Client Phone</th>
                <th>Client FB Name</th>
                <th>Interested In </th>
                <th>Converted</th>
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