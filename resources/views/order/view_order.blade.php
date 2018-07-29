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
          <table class="table table-bordered table-striped table-hover dataTable js-exportable">
            <thead>
              <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Amount</th>
                <th>Date Made</th>
                <th> </th>
              </tr>
            </thead>
            <tbody>
              <tr>
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