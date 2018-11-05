@extends("layouts.main_template_datatable")

@section('content')
<!-- Widgets -->
<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    
    <div class="card">

      <div class="header">
        <div class="col-lg-6">
          <h2> Sms Redemptions </h2>
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
              </tr>
            </thead>
            <tbody>
              @foreach($sms_redemptions as $sms_redemption)
              <tr>
                <td> {{ $sms_redemption->smslead_id }} </td>
                <td> {{ $sms_redemption->created_at }} </td>
                <td> {{ $sms_redemption->sms_from }} </td>
                <td> {{ $sms_redemption->sms_to }} </td>
                <td> {{ $sms_redemption->text }} </td>
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