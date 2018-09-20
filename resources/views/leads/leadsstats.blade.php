@extends("layouts.main_template_datatable")

@section('content')
<!-- Widgets -->
<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">

      <div class="header">
        <h2> Leads Statistics </h2>
      </div>

      <div class="body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover dataTable js-exportable">
            <thead>
              <tr>
                <th> # </th>
                <th> Date </th>
                <th> Staff Name </th>
                <th> Client Name </th>
                <th> Client Phone </th>
                <th> Client FB Name </th>
                <th> Interested In </th>
                <th> Converted </th>
              </tr>
            </thead>
            <tbody>
              @foreach($stats as $stat)
              <tr>
                <td> {{ $stat->lead_id }} </td>
                <td> {{ $stat->created_at }} </td>
                <td> {{ $stat->name }} </td> 
                <td> {{ $stat->client_name }} </td>
                <td> {{ $stat->client_phone }} </td>
                <td> {{ $stat->client_facebook_name }} </td>
                <td> {{ $stat->interested_in }} </td>
                <td> {{ $stat->converted }} </td>
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