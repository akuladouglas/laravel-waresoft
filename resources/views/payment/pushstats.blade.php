@extends("layouts.main_template_datatable")

@section('content')
<!-- Widgets -->
<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">

      <div class="header">
        <h2> Mpesa Push Statistics </h2>
      </div>

      <div class="body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover dataTable js-exportable">
            <thead>
              <tr>
                <th> # </th>
                <th> Order Name </th>
                <th> Staff </th>
                <th> Pushes Made </th>
                <th> Created At </th>
              </tr>
            </thead>
            <tbody>
              @foreach($stats as $stat)
              <tr>
                <td> {{ $stat->stk_stats_id }} </td>
                <td> {{ $stat->order_name }} </td>
                <td> {{ $stat->name }} </td>
                <td> {{ $stat->total_pushes }} </td>
                <td> {{ $stat->created_at }} </td>
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