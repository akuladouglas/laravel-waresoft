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
        <!--
        <div class="col-lg-6">
          <a href="{{url("leads/add")}}" class="btn btn-primary pull-right"> Add New Lead </a>
        </div>
        -->
        <div class="clearfix"></div>
      </div>

      <div class="body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover dataTable js-exportable">
            <thead>
              <tr>
                <th> # </th>
                <th> Date </th>
                <th> Client Phone </th>
                <th> Sent To </th>
                <th> Text </th>
                <th> Converted </th>
              </tr>
            </thead>
            <tbody>
              @foreach($stats as $stat)
              <tr>
                <td> {{ $stat->smslead_id }} </td>
                <td> {{ $stat->created_at }} </td>
                <td> {{ $stat->sms_from }} </td>
                <td> {{ $stat->sms_to }} </td>
                <td> {{ $stat->text }} </td>
                <td> 
                  @if($stat->converted)
                    <i class="material-icons">check</i>
                  @else
                   <a onclick="return confirm('You will mark this Lead as converted. Proceed ? ')" class="btn btn-primary btn-xs" href="{{ url('leads/mark-converted/'.$stat->smslead_id) }}"> Mark as Converted </a> 
                  @endif
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